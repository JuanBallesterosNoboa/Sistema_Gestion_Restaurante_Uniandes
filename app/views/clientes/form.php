<?php
require __DIR__ . '/../layout/header.php';
$editando = isset($cliente);
?>

<div class="hero">
    <div>
        <h1><?= $editando ? 'Editar cliente' : 'Registrar cliente' ?></h1>
        <p>Complete los datos solicitados.</p>
    </div>
</div>

<div class="card form-card">
<form method="post" action="index.php?controller=cliente&action=<?= $editando ? 'actualizar' : 'guardar' ?>">
    <?php if ($editando): ?><input type="hidden" name="id" value="<?= $cliente['id'] ?>"><?php endif; ?>
    <div class="grid">
        <label>Cédula *
            <input name="cedula" maxlength="10" pattern="[0-9]{10}" value="<?= htmlspecialchars($cliente['cedula'] ?? '') ?>" required>
        </label>
        <label>Nombres *
            <input name="nombres" maxlength="100" value="<?= htmlspecialchars($cliente['nombres'] ?? '') ?>" required>
        </label>
        <label>Apellidos *
            <input name="apellidos" maxlength="100" value="<?= htmlspecialchars($cliente['apellidos'] ?? '') ?>" required>
        </label>
        <label>Teléfono
            <input name="telefono" maxlength="10" pattern="[0-9]{7,10}" value="<?= htmlspecialchars($cliente['telefono'] ?? '') ?>">
        </label>
        <label>Correo electrónico
            <input type="email" name="correo" maxlength="100" value="<?= htmlspecialchars($cliente['correo'] ?? '') ?>">
        </label>
    </div>

    <button class="btn" type="submit"><?= $editando ? 'Actualizar cliente' : 'Guardar cliente' ?></button>
    <a class="btn secondary" href="index.php?controller=cliente">Cancelar</a>
</form>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
