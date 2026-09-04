<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="hero">
    <div><h1>Mesas</h1><p>Control de capacidad y estado de las mesas.</p></div>
    <a href="index.php?controller=mesa&action=crear" class="btn">+ Registrar mesa</a>
</div>

<?php if (!empty($_GET['error'])): ?>
    <div class="notice error"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<div class="card">
    <div class="search"><input id="buscar" type="text" placeholder="Buscar por número, capacidad o estado..."></div>
    <div class="table-wrap">
        <table id="tablaDatos">
            <thead><tr><th>ID</th><th>Número</th><th>Capacidad</th><th>Estado</th><th>Acciones</th></tr></thead>
            <tbody>
            <?php foreach ($mesas as $mesa): ?>
                <tr>
                    <td><b><?= $mesa['id'] ?></b></td>
                    <td>Mesa <?= $mesa['numero'] ?></td>
                    <td><?= $mesa['capacidad'] ?> personas</td>
                    <td><span class="badge"><?= htmlspecialchars($mesa['estado']) ?></span></td>
                    <td>
                        <a class="btn small" href="index.php?controller=mesa&action=editar&id=<?= $mesa['id'] ?>">Editar</a>
                        <a class="btn small danger" onclick="return confirm('¿Eliminar esta mesa?')" href="index.php?controller=mesa&action=eliminar&id=<?= $mesa['id'] ?>">Eliminar</a>
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
