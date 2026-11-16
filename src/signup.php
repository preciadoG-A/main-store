<?php
    //get payload from frontend
    include('../settings/basedata.php');

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $idnumber = $_POST['idnumber'];
    $mphone = $_POST['mphone'];
    $email = $_POST['email'];
    $pswd = MD5($_POST['pswd']);

    //prepary query
    $sql = "INSERT INTO 
    users (firstname, lastname, ident_number, mobile_phone, email, password) 
    VALUES (
            '$fname',   
            '$lname',  
            '$idnumber',    
            '$mphone',   
            '$email',   
            '$pswd')
    "; 
;

//excute query
$res = pg_query($local_conn, $sql);

if ($res) {
    echo "User has been created successfully!";
} else {
    echo "Error registering user hasn't been created successfully!";
}