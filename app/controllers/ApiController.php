<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->database();
        $this->call->model('AuthModel');
        $this->call->model('ProductModel');
        $this->call->library('api');
    }

    public function login()
    {
        $this->api->require_method('POST');
        $this->AuthModel->ensure_configured_admin();

        $body = $this->api->body();
        $rawIdentity = $body['identity'] ?? $body['username'] ?? null;
        $rawPassword = $body['password'] ?? null;
        if (!is_string($rawIdentity) || !is_string($rawPassword)) {
            $this->api->respond_error('Username/email and password are required.', 422);
        }
        $identity = trim($rawIdentity);
        $password = $rawPassword;

        if ($identity === '' || $password === '') {
            $this->api->respond_error('Username/email and password are required.', 422);
        }

        $statement = $this->db->raw(
            'SELECT id, username, email, password, role, is_active FROM users WHERE username = ? OR email = ? LIMIT 1',
            [$identity, $identity]
        );
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user || (int) $user['is_active'] !== 1 || !password_verify($password, $user['password'])) {
            $this->api->respond_error('The username/email or password is incorrect.', 401);
        }

        $tokens = $this->api->issue_tokens([
            'id' => (int) $user['id'],
            'role' => $user['role'],
            'scopes' => $user['role'] === 'admin' ? ['read', 'write', 'delete'] : ['read'],
        ]);

        unset($user['password'], $user['is_active']);
        $this->api->respond([
            'message' => 'Login successful.',
            'user' => $user,
            'tokens' => $tokens,
        ]);
    }

    public function refresh()
    {
        $this->api->require_method('POST');
        $body = $this->api->body();
        $refreshToken = (string) ($body['refresh_token'] ?? '');

        if ($refreshToken === '') {
            $this->api->respond_error('Refresh token is required.', 422);
        }

        $this->api->refresh_access_token($refreshToken);
    }

    public function logout()
    {
        $this->api->require_method('POST');
        $body = $this->api->body();
        $refreshToken = (string) ($body['refresh_token'] ?? '');

        if ($refreshToken === '') {
            $this->api->respond_error('Refresh token is required.', 422);
        }

        $this->api->revoke_refresh_token($refreshToken);
        $this->api->respond(['message' => 'Logout successful.']);
    }

    public function products()
    {
        $this->api->require_method('GET');
        $this->api->require_jwt();

        $statement = $this->db->raw('SELECT id, product_name, description, price, quantity, created_at FROM products ORDER BY created_at DESC, id DESC');
        $this->api->respond(['data' => $statement->fetchAll(PDO::FETCH_ASSOC)]);
    }

    public function create_product()
    {
        $this->api->require_method('POST');
        $this->require_scope('write');
        $product = $this->validated_product($this->api->body());

        $this->db->raw(
            'INSERT INTO products (product_name, description, price, quantity) VALUES (?, ?, ?, ?)',
            [$product['product_name'], $product['description'], $product['price'], $product['quantity']]
        );
        $id = (int) $this->db->raw('SELECT LAST_INSERT_ID() AS id')->fetch(PDO::FETCH_ASSOC)['id'];
        $created = $this->find_product($id);

        $this->api->respond(['message' => 'Product created.', 'data' => $created], 201);
    }

    public function update_product($id)
    {
        $this->api->require_method('PUT');
        $this->require_scope('write');
        $productId = $this->validated_id($id);
        $product = $this->validated_product($this->api->body());

        if (!$this->find_product($productId)) {
            $this->api->respond_error('Product not found.', 404);
        }

        $this->db->raw(
            'UPDATE products SET product_name = ?, description = ?, price = ?, quantity = ? WHERE id = ?',
            [$product['product_name'], $product['description'], $product['price'], $product['quantity'], $productId]
        );

        $this->api->respond(['message' => 'Product updated.', 'data' => $this->find_product($productId)]);
    }

    public function delete_product($id)
    {
        $this->api->require_method('DELETE');
        $this->require_scope('delete');
        $productId = $this->validated_id($id);

        if (!$this->find_product($productId)) {
            $this->api->respond_error('Product not found.', 404);
        }

        $this->db->raw('DELETE FROM products WHERE id = ?', [$productId]);
        $this->api->respond(['message' => 'Product deleted.']);
    }

    public function options()
    {
        $this->api->respond([], 204);
    }

    private function require_scope($scope)
    {
        $payload = $this->api->require_jwt();
        if (!in_array($scope, $payload['scopes'] ?? [], true)) {
            $this->api->respond_error('Forbidden.', 403);
        }
    }

    private function validated_product(array $input)
    {
        $rawName = $input['product_name'] ?? null;
        $rawDescription = $input['description'] ?? '';
        $rawPrice = $input['price'] ?? null;
        $rawQuantity = $input['quantity'] ?? null;

        if (!is_string($rawName) || !is_string($rawDescription) || !is_scalar($rawPrice) || !is_scalar($rawQuantity)) {
            $this->api->respond_error('Product fields have invalid formats.', 422);
        }

        $name = trim($rawName);
        $description = trim($rawDescription);
        $price = (string) $rawPrice;
        $quantity = filter_var((string) $rawQuantity, FILTER_VALIDATE_INT);

        if ($name === '' || strlen($name) > 100) {
            $this->api->respond_error('Product name is required and must be 100 characters or fewer.', 422);
        }
        if (strlen($description) > 65535) {
            $this->api->respond_error('Description is too long.', 422);
        }
        if (!preg_match('/^\d{1,8}(?:\.\d{1,2})?$/D', $price)) {
            $this->api->respond_error('Price must be a non-negative amount with up to two decimal places.', 422);
        }
        if ($quantity === false || $quantity < 0 || $quantity > 2147483647) {
            $this->api->respond_error('Quantity must be a non-negative whole number.', 422);
        }

        return [
            'product_name' => $name,
            'description' => $description,
            'price' => number_format((float) $price, 2, '.', ''),
            'quantity' => $quantity,
        ];
    }

    private function validated_id($id)
    {
        $productId = filter_var($id, FILTER_VALIDATE_INT);
        if ($productId === false || $productId < 1) {
            $this->api->respond_error('Invalid product id.', 400);
        }

        return $productId;
    }

    private function find_product($id)
    {
        $statement = $this->db->raw(
            'SELECT id, product_name, description, price, quantity, created_at FROM products WHERE id = ? LIMIT 1',
            [$id]
        );
        return $statement->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
