<div class="field">
	<label for="product_name">Product name</label>
	<input id="product_name" name="product_name" maxlength="100" value="<?= htmlspecialchars((string) ($old['product_name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
</div>
<div class="field">
	<label for="description">Description</label>
	<textarea id="description" name="description" rows="4"><?= htmlspecialchars((string) ($old['description'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
</div>
<div class="field-grid">
	<div class="field">
		<label for="price">Price</label>
		<input id="price" name="price" type="number" min="0" step="0.01" value="<?= htmlspecialchars((string) ($old['price'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
	</div>
	<div class="field">
		<label for="quantity">Quantity</label>
		<input id="quantity" name="quantity" type="number" min="0" step="1" value="<?= htmlspecialchars((string) ($old['quantity'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
	</div>
</div>
