<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f4ef">
    <title>Sign in | Product Desk</title>
    <?php include __DIR__ . '/../products/styles.php'; ?>
</head>
<body class="login-page">
    <header class="shell login-header">
        <a class="brand" href="<?= site_url('login') ?>" aria-label="Product Desk home">
            <span class="brand-mark" aria-hidden="true">P</span>
            <span class="brand-name">Product Desk</span>
        </a>
    </header>

    <main class="login-main">
        <section class="login-content" aria-labelledby="login-title">
            <p class="eyebrow">Private workspace</p>
            <h1 class="login-title" id="login-title">Welcome back.</h1>
            <p class="login-intro">Sign in to continue to your collection.</p>

            <?php if (!empty($error)): ?>
                <div class="notice notice-error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('login') ?>">
                <div class="field">
                    <label for="username">Username</label>
                    <input id="username" name="username" value="<?= htmlspecialchars($username ?? '', ENT_QUOTES, 'UTF-8') ?>" autocomplete="username" required>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required>
                </div>
                <button class="button button-primary" type="submit">Sign in</button>
            </form>
        </section>
    </main>

    <footer class="login-footer">Product Desk &middot; Private access</footer>
</body>
</html>