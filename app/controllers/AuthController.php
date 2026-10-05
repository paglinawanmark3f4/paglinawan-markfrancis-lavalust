<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->database();
        $this->call->model('AuthModel');
    }

    private function ensure_default_admin()
    {
        $this->AuthModel->ensure_configured_admin();
    }

    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->ensure_default_admin();

        if (!empty($_SESSION['user_id'])) {
            redirect('products');
            exit;
        }

        $data = [
            'error' => $_SESSION['auth_error'] ?? null,
            'username' => $_SESSION['auth_username'] ?? '',
        ];
        unset($_SESSION['auth_error'], $_SESSION['auth_username']);
        $this->call->view('auth/login', $data);
    }

    public function authenticate()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->ensure_default_admin();

        $username = trim((string) $this->io->post('username'));
        $password = (string) $this->io->post('password');
        $user = $this->AuthModel->find_by_username($username);
        $user_data = is_object($user) ? get_object_vars($user) : (array) $user;
        $stored_password = (string) ($user_data['password'] ?? '');
        $is_active = (int) ($user_data['is_active'] ?? 0) === 1;

        if (!$user || !$is_active || !password_verify($password, $stored_password)) {
            $_SESSION['auth_error'] = 'The username or password is incorrect.';
            $_SESSION['auth_username'] = $username;
            redirect('login');
            exit;
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user_data['id'] ?? null;
        redirect('products');
        exit;
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        redirect('login');
        exit;
    }
}
