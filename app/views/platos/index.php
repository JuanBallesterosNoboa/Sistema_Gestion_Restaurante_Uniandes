<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="hero">
    <div>
        <h1>Platos</h1>
        <p>Administración del menú del restaurante.</p>
    </div>
    <a href="index.php?controller=plato&action=crear" class="btn">+ Registrar plato</a>
</div>

<?php if (!empty($_GET['error'])): ?>
    <div class="notice error"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<div class="card">
    <div class="search"><input id="buscar" type="text" placeholder="Buscar por nombre, descripción o precio..."></div>
    <div class="table-wrap">
        <table id="tablaDatos">
            <thead><tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Disponible</th><th>Acciones</th></tr></thead>
            <tbody>
            <?php foreach ($platos as $plato): ?>
                <tr>
                    <td><b><?= $plato['id'] ?></b></td>
                    <td><?= htmlspecialchars($plato['nombre']) ?></td>
                    <td><?= htmlspecialchars($plato['descripcion']) ?></td>
                    <td>$<?= number_format($plato['precio'], 2) ?></td>
                    <td><span class="badge"><?= $plato['disponible'] ? 'Sí' : 'No' ?></span></td>
                    <td>
                        <a class="btn small" href="index.php?controller=plato&action=editar&id=<?= $plato['id'] ?>">Editar</a>
                        <a class="btn small danger" onclick="return confirm('¿Eliminar este plato?')" href="index.php?controller=plato&action=eliminar&id=<?= $plato['id'] ?>">Eliminar</a>
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
