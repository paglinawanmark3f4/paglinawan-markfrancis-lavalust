<?php

class Seed_admin_user
{
    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->database();
    }

    public function up()
    {
        $email = getenv('ADMIN_EMAIL');
        $password = getenv('ADMIN_PASSWORD');
        if (!$email || !$password) {
            return;
        }

        $existing = $this->_lava->db->table('users')->where('email', $email)->get();
        if ($existing) {
            return;
        }

        $this->_lava->db->table('users')->insert([
            'username' => strstr($email, '@', true),
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'admin',
            'is_active' => 1,
        ]);
    }

    public function down()
    {
    }
}
