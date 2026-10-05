<?php
define('PREVENT_DIRECT_ACCESS', true);

class Controller {
    public function __construct() {}
}

require __DIR__ . '/../app/controllers/AuthController.php';

if (!method_exists(AuthController::class, 'ensure_default_admin')) {
    fwrite(STDERR, "Missing default admin bootstrap\n");
    exit(1);
}

echo "default admin bootstrap present\n";
