<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="hero">
    <div><h1>Pedidos</h1><p>Administración de los pedidos del restaurante.</p></div>
    <div>
        <a href="index.php?controller=reporte" class="btn report">Reporte por cliente</a>
        <a href="index.php?controller=pedido&action=crear" class="btn">+ Registrar pedido</a>
    </div>
</div>

<div class="card">
    <div class="search"><input id="buscar" type="text" placeholder="Buscar por cliente, plato, mesa o estado..."></div>
    <div class="table-wrap">
        <table id="tablaDatos">
            <thead>
                <tr><th>ID</th><th>Fecha</th><th>Cliente</th><th>Plato</th><th>Mesa</th><th>Cantidad</th><th>Estado</th><th>Total</th><th>Acciones</th></tr>
            </thead>
            <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><b><?= $pedido['id'] ?></b></td>
                    <td><?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></td>
                    <td><?= htmlspecialchars($pedido['cliente']) ?></td>
                    <td><?= htmlspecialchars($pedido['plato']) ?></td>
                    <td>Mesa <?= $pedido['mesa'] ?></td>
                    <td><?= $pedido['cantidad'] ?></td>
                    <td><span class="badge"><?= htmlspecialchars($pedido['estado']) ?></span></td>
                    <td><b>$<?= number_format($pedido['total'], 2) ?></b></td>
                    <td>
                        <a class="btn small" href="index.php?controller=pedido&action=editar&id=<?= $pedido['id'] ?>">Editar</a>
                        <a class="btn small danger" onclick="return confirm('¿Eliminar este pedido?')" href="index.php?controller=pedido&action=eliminar&id=<?= $pedido['id'] ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById('buscar').addEventListener('input', function () {
    const texto = this.value.toLowerCase();
    document.querySelectorAll('#tablaDatos tbody tr').forEach(fila => {
        fila.style.display = fila.innerText.toLowerCase().includes(texto) ? '' : 'none';
    });
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
