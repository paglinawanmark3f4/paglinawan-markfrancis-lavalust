<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f4ef">
    <title>Products | Product Desk</title>
    <?php include __DIR__ . '/styles.php'; ?>
</head>
<body>
<header class="site-header">
    <nav class="shell site-nav" aria-label="Main navigation">
        <a class="brand" href="<?= site_url('products') ?>">
            <span class="brand-mark" aria-hidden="true">P</span>
            <span class="brand-name">Product Desk</span>
        </a>
        <form method="post" action="<?= site_url('logout') ?>">
            <button class="button button-secondary button-small" type="submit">Sign out</button>
        </form>
    </nav>
</header>

<main class="shell page-main">
    <div class="page-heading">
        <div>
            <p class="eyebrow">Inventory</p>
            <h1>Product catalog</h1>
            <p class="page-subtitle">A clear view of your collection.</p>
        </div>
        <a class="button button-primary" href="<?= site_url('products/create') ?>">Add product</a>
    </div>

    <?php foreach (['success' => 'notice', 'error' => 'notice notice-error'] as $key => $class): ?>
        <?php if (!empty($$key)): ?>
            <div class="<?= $class ?>" role="status"><?= htmlspecialchars($$key, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if (empty($products)): ?>
        <section class="empty-state" aria-labelledby="empty-title">
            <h2 id="empty-title">Your catalog is ready.</h2>
            <p>Add your first product to begin.</p>
            <a class="button button-primary" href="<?= site_url('products/create') ?>">Add first product</a>
        </section>
    <?php else: ?>
        <div class="table-scroll">
            <table class="products-table">
                <caption class="visually-hidden">Current product inventory</caption>
                <thead>
                    <tr><th scope="col">ID</th><th scope="col">Product</th><th scope="col">Description</th><th scope="col">Price</th><th scope="col">Quantity</th><th scope="col">Created</th><th scope="col">Actions</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <?php
                        $read_value = static function ($record, $key) {
                            if (is_array($record)) {
                                return $record[$key] ?? '';
                            }
                            return is_object($record) ? ($record->$key ?? '') : '';
                        };
                        $value = static fn($key) => htmlspecialchars((string) $read_value($product, $key), ENT_QUOTES, 'UTF-8');
                        $id = rawurlencode((string) $read_value($product, 'id'));
                        ?>
                        <tr>
                            <td class="product-id" data-label="ID"><?= $value('id') ?></td>
                            <td class="product-name" data-label="Product"><?= $value('product_name') ?></td>
                            <td class="product-description" data-label="Description"><?= $value('description') !== '' ? $value('description') : '&mdash;' ?></td>
                            <td class="product-price" data-label="Price">&#8369;<?= $value('price') ?></td>
                            <td data-label="Quantity"><?= $value('quantity') ?></td>
                            <td data-label="Created"><?= $value('created_at') ?></td>
                            <td class="product-actions" data-label="Actions">
                                <a class="button button-secondary button-small" href="<?= site_url('products/edit/' . $id) ?>">Edit</a>
                                <form method="post" action="<?= site_url('products/delete/' . $id) ?>" onsubmit="return confirm('Delete this product?');">
                                    <button class="button button-danger button-small" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>
</body>
</html>
