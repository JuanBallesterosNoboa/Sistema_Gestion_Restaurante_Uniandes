<?php
require __DIR__ . '/../layout/header.php';
$editando = isset($pedido);
$fecha = $pedido['fecha'] ?? date('Y-m-d H:i');
?>

<div class="hero">
    <div><h1><?= $editando ? 'Editar pedido' : 'Registrar pedido' ?></h1><p>El total se calculará automáticamente.</p></div>
</div>

<div class="card form-card">
<form method="post" action="index.php?controller=pedido&action=<?= $editando ? 'actualizar' : 'guardar' ?>">
    <?php if ($editando): ?><input type="hidden" name="id" value="<?= $pedido['id'] ?>"><?php endif; ?>
    <div class="grid">
        <label>Cliente *
            <select name="cliente_id" required>
                <option value="">Seleccione...</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?= $cliente['id'] ?>" <?= ($pedido['cliente_id'] ?? 0) == $cliente['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cliente['nombres'] . ' ' . $cliente['apellidos']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Plato *
            <select id="plato" name="plato_id" required>
                <option value="">Seleccione...</option>
                <?php foreach ($platos as $plato): ?>
                    <option value="<?= $plato['id'] ?>" data-precio="<?= $plato['precio'] ?>"
                        <?= ($pedido['plato_id'] ?? 0) == $plato['id'] ? 'selected' : '' ?>
                        <?= !$plato['disponible'] && ($pedido['plato_id'] ?? 0) != $plato['id'] ? 'disabled' : '' ?>>
                        <?= htmlspecialchars($plato['nombre']) ?> - $<?= number_format($plato['precio'], 2) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Mesa *
            <select name="mesa_id" required>
                <option value="">Seleccione...</option>
                <?php foreach ($mesas as $mesa): ?>
                    <option value="<?= $mesa['id'] ?>" <?= ($pedido['mesa_id'] ?? 0) == $mesa['id'] ? 'selected' : '' ?>>
                        Mesa <?= $mesa['numero'] ?> - <?= htmlspecialchars($mesa['estado']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Cantidad *
            <input id="cantidad" type="number" name="cantidad" min="1" max="50" value="<?= $pedido['cantidad'] ?? 1 ?>" required>
        </label>

        <label>Fecha y hora *
            <input type="datetime-local" name="fecha" value="<?= date('Y-m-d\TH:i', strtotime($fecha)) ?>" required>
        </label>

        <label>Estado *
            <select name="estado" required>
                <?php foreach (['Pendiente', 'En preparación', 'Servido', 'Pagado', 'Cancelado'] as $estado): ?>
                    <option value="<?= $estado ?>" <?= ($pedido['estado'] ?? 'Pendiente') === $estado ? 'selected' : '' ?>><?= $estado ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>

    <div class="total-box">Total calculado: <strong id="total">$0.00</strong></div>
    <button class="btn" type="submit"><?= $editando ? 'Actualizar pedido' : 'Guardar pedido' ?></button>
    <a class="btn secondary" href="index.php?controller=pedido">Cancelar</a>
</form>
</div>

<script>
const plato = document.getElementById('plato');
const cantidad = document.getElementById('cantidad');
const total = document.getElementById('total');

function calcular() {
    const precio = Number(plato.options[plato.selectedIndex]?.dataset.precio || 0);
    total.textContent = '$' + (precio * Number(cantidad.value || 0)).toFixed(2);
}

plato.addEventListener('change', calcular);
cantidad.addEventListener('input', calcular);
calcular();
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
