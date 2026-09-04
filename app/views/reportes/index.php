<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="hero no-print">
    <div><h1>Reporte de pedidos por cliente</h1><p>Seleccione un cliente o consulte todos los pedidos.</p></div>
    <button class="btn report" onclick="window.print()">Imprimir reporte</button>
</div>

<div class="card no-print">
    <form method="get" class="filter-form">
        <input type="hidden" name="controller" value="reporte">
        <label>Cliente
            <select name="cliente_id">
                <option value="0">Todos los clientes</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?= $cliente['id'] ?>" <?= $clienteId == $cliente['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cliente['nombres'] . ' ' . $cliente['apellidos']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <button class="btn" type="submit">Generar reporte</button>
    </form>
</div>

<div class="print-title">
    <h2>REPORTE DE PEDIDOS POR CLIENTE</h2>
    <p>Fecha de generación: <?= date('d/m/Y') ?></p>
</div>

<div class="card">
    <h2>Resumen por cliente</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Cédula</th><th>Cliente</th><th>Cantidad de pedidos</th><th>Total consumido</th></tr></thead>
            <tbody>
            <?php $totalGeneral = 0; ?>
            <?php foreach ($resumen as $dato): ?>
                <?php $totalGeneral += (float)$dato['total']; ?>
                <tr>
                    <td><?= htmlspecialchars($dato['cedula']) ?></td>
                    <td><?= htmlspecialchars($dato['cliente']) ?></td>
                    <td><?= $dato['pedidos'] ?></td>
                    <td><b>$<?= number_format($dato['total'], 2) ?></b></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot><tr><th colspan="3">TOTAL GENERAL</th><th>$<?= number_format($totalGeneral, 2) ?></th></tr></tfoot>
        </table>
    </div>
</div>

<div class="card">
    <h2>Detalle de pedidos</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>ID</th><th>Fecha</th><th>Cliente</th><th>Plato</th><th>Mesa</th><th>Cantidad</th><th>Estado</th><th>Total</th></tr></thead>
            <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= $pedido['id'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></td>
                    <td><?= htmlspecialchars($pedido['cliente']) ?></td>
                    <td><?= htmlspecialchars($pedido['plato']) ?></td>
                    <td>Mesa <?= $pedido['mesa'] ?></td>
                    <td><?= $pedido['cantidad'] ?></td>
                    <td><?= htmlspecialchars($pedido['estado']) ?></td>
                    <td>$<?= number_format($pedido['total'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
