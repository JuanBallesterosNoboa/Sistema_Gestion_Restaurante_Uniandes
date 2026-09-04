<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="hero">
    <div>
        <h1>Clientes</h1>
        <p>Registro y consulta de clientes del restaurante.</p>
    </div>
    <a href="index.php?controller=cliente&action=crear" class="btn">+ Registrar cliente</a>
</div>

<?php if (!empty($_GET['error'])): ?>
    <div class="notice error"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<div class="card">
    <div class="search">
        <input id="buscar" type="text" placeholder="Buscar por cédula, nombres, apellidos, teléfono o correo...">
    </div>

    <div class="table-wrap">
        <table id="tablaDatos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cédula</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><b><?= $cliente['id'] ?></b></td>
                    <td><?= htmlspecialchars($cliente['cedula']) ?></td>
                    <td><?= htmlspecialchars($cliente['nombres']) ?></td>
                    <td><?= htmlspecialchars($cliente['apellidos']) ?></td>
                    <td><?= htmlspecialchars($cliente['telefono']) ?></td>
                    <td><?= htmlspecialchars($cliente['correo']) ?></td>
                    <td>
                        <a class="btn small" href="index.php?controller=cliente&action=editar&id=<?= $cliente['id'] ?>">Editar</a>
                        <a class="btn small danger" onclick="return confirm('¿Eliminar este cliente?')" href="index.php?controller=cliente&action=eliminar&id=<?= $cliente['id'] ?>">Eliminar</a>
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
