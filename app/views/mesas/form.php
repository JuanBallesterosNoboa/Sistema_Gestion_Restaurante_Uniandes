<?php
require __DIR__ . '/../layout/header.php';
$editando = isset($mesa);
?>

<div class="hero">
    <div><h1><?= $editando ? 'Editar mesa' : 'Registrar mesa' ?></h1><p>Complete los datos de la mesa.</p></div>
</div>

<div class="card form-card">
<form method="post" action="index.php?controller=mesa&action=<?= $editando ? 'actualizar' : 'guardar' ?>">
    <?php if ($editando): ?><input type="hidden" name="id" value="<?= $mesa['id'] ?>"><?php endif; ?>
    <div class="grid">
        <label>Número de mesa *
            <input type="number" name="numero" min="1" value="<?= htmlspecialchars($mesa['numero'] ?? '') ?>" required>
        </label>
        <label>Capacidad *
            <input type="number" name="capacidad" min="1" max="20" value="<?= htmlspecialchars($mesa['capacidad'] ?? '4') ?>" required>
        </label>
        <label>Estado *
            <select name="estado" required>
                <?php foreach (['Disponible', 'Ocupada', 'Reservada'] as $estado): ?>
                    <option value="<?= $estado ?>" <?= ($mesa['estado'] ?? 'Disponible') === $estado ? 'selected' : '' ?>><?= $estado ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>

    <button class="btn" type="submit"><?= $editando ? 'Actualizar mesa' : 'Guardar mesa' ?></button>
    <a class="btn secondary" href="index.php?controller=mesa">Cancelar</a>
</form>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
