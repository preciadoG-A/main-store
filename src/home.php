<?php
session_start();

// Si el usuario NO ha iniciado sesión, lo redirige al login y detiene el código
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.html');
    exit;
}

// Si SÍ tiene sesión, no se pone 'else': simplemente continúa y carga la página
include('../settings/basedata.php');

// Guardamos el nombre completo de forma segura
$nombreCompleto = ($_SESSION['user_firstname'] ?? '') . ' ' . ($_SESSION['user_lastname'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/style_home.css">
</head>
<body>
    <center>
        <h2><?= htmlspecialchars(trim($nombreCompleto)) ?></h2>
        <h3>Welcome to Main Store</h3>
        <a href="logout.php">Logout</a>
    </center>

    <br>
    <strong>Menu:</strong> <br>
    <a href="list_users.php">List users</a>
</body>
</html>
