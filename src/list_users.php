<?php
/*
    Use this URL to print data in browser:
    http://localhost/main-store/src/list_users.php
*/
session_start();
include('../settings/basedata.php');

$rolActual = $_SESSION['rol'] ?? 'cliente';
$esAdmin = ($rolActual === 'administrador');

// Get data from users table (ordenado por ID para que no salten de fila)
$sql = "
    select 
        id,
        firstname ||' ' || lastname as fullname,
        email,
        mobile_phone,
        case when status = true then 'Active' else 'Inactive' end as status,
        url_photo
    from
        users
    order by id asc
";
$res = pg_query($local_conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="css/style_list_users.css">
</head>
<body class="role-<?= htmlspecialchars($rolActual) ?>">

<center>
    <h1>USERS LIST</h1>
    <p>Rol actual: <strong><?= strtoupper(htmlspecialchars($rolActual)) ?></strong></p>
    <a href="role_access.php">Cambiar Rol</a>
    <?php if ($esAdmin): ?>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="signup.html">Create user</a>
    <?php endif; ?>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="logout.php">Logout</a>
    <br><br>

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

                    // Ícono del estado actual
                    $status_icon = ($row['status'] === 'Active') ? 'enable.png' : 'disable.png';
                    echo "<td><img src='icon/" . $status_icon . "' alt='" . htmlspecialchars($row['status']) . "' width='20'> " . htmlspecialchars($row['status']) . "</td>";

                    if ($esAdmin) {
                        $nuevo_estado = ($row['status'] === 'Active') ? 'false' : 'true';

                        echo "<td class='actions-col'>
                                <a href='edit_user.php?id=" . urlencode($row['id']) . "' title='Editar'>
                                    <img src='icon/edit.png' alt='Edit' width='20'>
                                </a>
                                &nbsp;
                                <a href='update_user_status.php?userID=" . urlencode($row['id']) . "&userStatus=" . $nuevo_estado . "' title='Cambiar Estado'>
                                    <img src='icon/disable.png' alt='Status' width='20'>
                                </a>
                                &nbsp;
                                <a href='delete_user.php?userID=" . urlencode($row['id']) . "' title='Eliminar' onclick='return confirm(\"¿Seguro que deseas eliminar este usuario?\");'>
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
