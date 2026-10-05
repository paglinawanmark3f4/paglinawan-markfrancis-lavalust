<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Model: AuthModel
 * 
 * Automatically generated via CLI.
 */
class AuthModel extends Model {
    protected $table = 'users';
    protected $primary_key = 'id';
    protected $fillable = ['username', 'email', 'password', 'role', 'is_active'];
    protected $guarded = ['id'];

    public function __construct()
    {
        parent::__construct();
    }

    public function find_by_username($username)
    {
        return $this->find_by('username', $username);
    }

    public function ensure_configured_admin()
    {
        $email = trim((string) getenv('ADMIN_EMAIL'));
        $password = (string) getenv('ADMIN_PASSWORD');
        $username = trim((string) (getenv('ADMIN_USERNAME') ?: strstr($email, '@', true)));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '' || $username === '' || strlen($username) > 100) {
            return;
        }

        if ($this->count() > 0) {
            return;
        }

        $this->insert([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'admin',
            'is_active' => 1,
        ]);
    }
}