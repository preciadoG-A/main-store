<?php
/*
Use this endpoint to test request 
http://localhost/main-store/src/update_user_status.php?userID=ANY-ID-NUMBER
*/





include('../settings/basedata.php');

//Get data
$user_id = $_GET['userID'];
$user_status = $_GET['userStatus'];

if ($user_id) {
    // Invierte el estado booleano (true pasa a false, y false pasa a true) directamente en PostgreSQL
    $sql = "UPDATE users SET status = NOT status WHERE id = $1";
    $res = pg_query_params($local_conn, $sql, array($user_id));

    if ($res) {
        header("Location: list_users.php");
        exit;
    } else {
        echo "Error en PostgreSQL: " . pg_last_error($local_conn);
    }
} else {
    echo "Error: No se recibió el ID del usuario.";
}

$sql_update_user_status = "UPDATE users SET status = $new_userStatus WHERE id = $user_id ";
$res = pg_query($local_conn, $sql_update_user_status);


if($res){
    echo "<script>alert('User status has been updated successfully')</script>";
    header('refresh:0;url=list_users.php');
} else {
    echo "<script>alert('User status has not been updated')</script>";
    header('refresh:0;url=list_users.php');
}