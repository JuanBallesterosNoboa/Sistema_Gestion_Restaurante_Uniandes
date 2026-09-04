<?php
require __DIR__ . '/../layout/header.php';
$editando = isset($plato);
?>

<div class="hero">
    <div><h1><?= $editando ? 'Editar plato' : 'Registrar plato' ?></h1><p>Complete la información del plato.</p></div>
</div>

<div class="card form-card">
<form method="post" action="index.php?controller=plato&action=<?= $editando ? 'actualizar' : 'guardar' ?>">
    <?php if ($editando): ?><input type="hidden" name="id" value="<?= $plato['id'] ?>"><?php endif; ?>
    <div class="grid">
        <label>Nombre del plato *
            <input name="nombre" maxlength="100" value="<?= htmlspecialchars($plato['nombre'] ?? '') ?>" required>
        </label>
        <label>Precio *
            <input type="number" name="precio" min="0.01" step="0.01" value="<?= htmlspecialchars($plato['precio'] ?? '') ?>" required>
        </label>
        <label class="full">Descripción
            <textarea name="descripcion" maxlength="255" rows="4"><?= htmlspecialchars($plato['descripcion'] ?? '') ?></textarea>
        </label>
        <label class="check">
            <input type="checkbox" name="disponible" value="1" <?= !isset($plato) || $plato['disponible'] ? 'checked' : '' ?>> Disponible para pedidos
        </label>
    </div>

    <button class="btn" type="submit"><?= $editando ? 'Actualizar plato' : 'Guardar plato' ?></button>
    <a class="btn secondary" href="index.php?controller=plato">Cancelar</a>
</form>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
