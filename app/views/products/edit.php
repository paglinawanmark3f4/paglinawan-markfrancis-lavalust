<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#f5f4ef">
	<title>Edit product | Product Desk</title>
	<?php include __DIR__ . '/styles.php'; ?>
</head>
<body>
<?php $product_data = []; if (isset($product)) { $product_data = is_object($product) ? get_object_vars($product) : $product; } ?>
<header class="site-header">
	<nav class="shell site-nav" aria-label="Main navigation">
		<a class="brand" href="<?= site_url('products') ?>"><span class="brand-mark" aria-hidden="true">P</span><span class="brand-name">Product Desk</span></a>
		<a class="button button-secondary button-small" href="<?= site_url('products') ?>">All products</a>
	</nav>
</header>
<main class="shell form-shell">
	<p class="breadcrumb"><a href="<?= site_url('products') ?>">Products</a> / Edit product</p>
	<div class="form-heading">
		<p class="eyebrow">Catalog entry</p>
		<h1>Edit product</h1>
		<p class="page-subtitle">Update the details for this item.</p>
	</div>
	<?php if (!empty($errors)): ?>
		<div class="notice notice-error" role="alert"><ul class="error-list"><?php foreach ($errors as $error): ?><li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li><?php endforeach; ?></ul></div>
	<?php endif; ?>
	<?php
	$old = [
		'product_name' => $product_data['product_name'] ?? '',
		'description' => $product_data['description'] ?? '',
		'price' => $product_data['price'] ?? '',
		'quantity' => $product_data['quantity'] ?? '',
	];
	?>
	<form method="post" action="<?= site_url('products/edit/' . rawurlencode((string) ($product_data['id'] ?? ''))) ?>">
		<div class="form-section"><?php include __DIR__ . '/form.php'; ?></div>
		<div class="form-actions">
			<a class="button button-secondary" href="<?= site_url('products') ?>">Cancel</a>
			<button class="button button-primary" type="submit">Save changes</button>
		</div>
	</form>
</main>
</body>
</html>
