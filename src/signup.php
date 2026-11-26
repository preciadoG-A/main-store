<?php

    //Get database connection
    require('../settings/basedata.php');

    //Get data from frontend
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $ident_number = $_POST['idnumber'];
    $mobile_phone = $_POST['mphone'];
    $email = $_POST['email'];
    $passwd = MD5 ($_POST['pswd']);
    $PHOTO_URL = 'photos/photo_default.png';


$sql_check_email = "SELECT * FROM users WHERE email = '$email' ";
$res = pg_query($local_conn, $sql_check_email);
$total = pg_num_rows($res);
if ($total < 1){

    //Prepare query
    $sql = "INSERT INTO users (firstname, lastname, ident_number, email, password, url_photo, mobile_phone) 
    VALUES (
        '$first_name', 
        '$last_name', 
        '$ident_number',
        '$email', 
        '$passwd', 
        '$PHOTO_URL',
        '$mobile_phone'
    );
";

// Execude query
$res = pg_query($local_conn, $sql);

if($res){
    //echo "user has been created successfull !!";
    echo "<script>alert('user has been created successfully')</script>";
    header('refresh:0;url=signin.html');
} else {
    echo "Error: User hasn't been created successfull !!";
} 
}
else {
    echo "<script>alert('User email already exists. Try again')</script>";
    header('refresh:0;url=signup.html');
}

    //Get data from frontend
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $ident_number = $_POST['idnumber'];
    $mobile_phone = $_POST['mphone'];
    $email = $_POST['email'];
    $passwd = MD5 ($_POST['pswd']);

    

    echo "<br>" . $first_name;
    echo "<br>" . $last_name;
    echo "<br>" . $ident_number;
    echo "<br>" . $mobile_phone;
    echo "<br>" . $email;
    echo "<br>" . $passwd;
