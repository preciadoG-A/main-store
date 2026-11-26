<?php
/*
    Use this URL to print data in browser:
    http://localhost/main-store/src/role_access.php
*/
session_start();
include('../settings/basedata.php');

if (isset($_GET['rol'])) {
    $_SESSION['rol'] = ($_GET['rol'] === 'administrador') ? 'administrador' : 'cliente';
} elseif (isset($_POST['rol'])) {
    $_SESSION['rol'] = ($_POST['rol'] === 'administrador') ? 'administrador' : 'cliente';
} elseif (!isset($_SESSION['rol'])) {
    $_SESSION['rol'] = 'cliente';
}

$rolActual = $_SESSION['rol'];
$esAdmin = ($rolActual === 'administrador');

//Get data from users table
$sql="
    select 
	    id,
	    firstname ||' ' || lastname as fullname,
	    email,
	    mobile_phone,
	    case when status = true then 'Active' else 'Inactive' end as status,
        url_photo
    from
	    users
        ";
        $res = pg_query($local_conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso por Rol</title>
    <link rel="stylesheet" href="css/style_role_acces.css?v=3">
</head>
<body class="role-<?= htmlspecialchars($rolActual) ?>">

<center>
    <h1>ACCESS BY ROLE</h1>
    <p>Rol actual: <strong><?= strtoupper(htmlspecialchars($rolActual)) ?></strong></p>

    <form method="post" action="role_access.php">
        <label for="rol">Seleccionar rol:</label>
        <select name="rol" id="rol">
            <option value="cliente" <?= !$esAdmin ? 'selected' : '' ?>>Cliente (Solo ver)</option>
            <option value="administrador" <?= $esAdmin ? 'selected' : '' ?>>Administrador (Editar)</option>
        </select>
        <button type="submit">Entrar con este rol</button>
    </form>
    <br>

    <a href="role_access.php?rol=administrador">Entrar como Administrador</a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="role_access.php?rol=cliente">Entrar como Cliente</a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="list_users.php">Ver lista</a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="logout.php">Logout</a>
    <br><br>

    <?php if ($esAdmin): ?>
        <p>Modo <strong>Administrador</strong>: puedes editar, cambiar estado y eliminar.</p>
    <?php else: ?>
        <p>Modo <strong>Cliente</strong>: solo lectura.</p>
    <?php endif; ?>

    <table border="1" style="border-collapse: collapse; text-align: center;">
        <thead>
            <tr>
                <th>Photo</th>
                <th>ID</th>
                <th>Fullname</th>
                <th>Email</th>
                <th>Mobile Phone</th>
                <th>Status</th>
                <?php if ($esAdmin): ?>
                    <th class="actions-col">Options</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($res && pg_num_rows($res) > 0) {
                while ($row = pg_fetch_assoc($res)) {
                    echo "<tr>";

                    $photo = !empty($row['url_photo']) ? $row['url_photo'] : 'photos/photo_default.png';
                    echo "<td><img src='" . htmlspecialchars($photo) . "' alt='Foto' width='40' height='40'></td>";

                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['mobile_phone']) . "</td>";

                    $status_icon = ($row['status'] === 'Active') ? 'enable.png' : 'disable.png';
                    echo "<td><img src='icon/" . $status_icon . "' alt='" . htmlspecialchars($row['status']) . "' width='20'> " . htmlspecialchars($row['status']) . "</td>";

                    if ($esAdmin) {
                        echo "<td class='actions-col'>
                                <a href='edit_user.php?id=" . urlencode($row['id']) . "' title='Editar'>
                                    <img src='icon/edit.png' alt='Edit' width='20'>
                                </a>
                                &nbsp;
                                <a href='update_user_status.php?id=" . urlencode($row['id']) . "' title='Cambiar Estado'>
                                    <img src='icon/disable.png' alt='Status' width='20'>
                                </a>
                                &nbsp;
                                <a href='delete_user.php?id=" . urlencode($row['id']) . "' title='Eliminar' onclick='return confirm(\"¿Seguro que deseas eliminar este usuario?\");'>
                                    <img src='icon/delete.png' alt='Delete' width='20'>
                                </a>
                              </td>";
                    }

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay usuarios registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</center>

</body>
</html>