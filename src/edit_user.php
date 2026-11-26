<?php
session_start();
if (($_SESSION['rol'] ?? 'cliente') !== 'administrador') {
    http_response_code(403);
    exit("Acceso denegado: solo el rol administrador puede editar.");
}

include('../settings/basedata.php');

$id = $_GET['id'];   // el número que llegó en la URL

$sql = 'SELECT * FROM users WHERE id = $1';
$result = pg_query_params($local_conn, $sql, array($id));
$user = pg_fetch_assoc($result);   // una sola fila: el usuario a editar
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar usuario</title>
    <link rel="stylesheet" href="css/style_edit_usuario.css">
</head>
<body>
    <h1>Editar usuario</h1>

    <form action="update_user.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

        <label>Nombre</label><br>
        <input type="text" name="firstname" value="<?php echo $user['firstname']; ?>" required><br><br>

        <label>Apellido</label><br>
        <input type="text" name="lastname" value="<?php echo $user['lastname']; ?>" required><br><br>

        <label>Correo</label><br>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>

        <label>Celular</label><br>
        <input type="text" name="mobile_phone" value="<?php echo $user['mobile_phone']; ?>" required><br><br>

        <?php 
            $fotoActual = !empty($user['url_photo']) ? $user['url_photo'] : 'photos/photo_default.png';
        ?>
        <p>Foto actual:</p>
        <img src="<?php echo htmlspecialchars($fotoActual); ?>" width="120" alt="Foto de usuario"><br><br>



        <label>Foto (JPG o PNG)</label><br>
        <input type="file" name="photo" accept=".jpg, .jpeg, .png"><br><br>

        <button type="submit">Guardar</button>
        <a href="list_users.php">Cancelar</a>
    </form>
</body>
</html>