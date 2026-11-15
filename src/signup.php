<?php
    //get payload from frontend
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $idnumber = $_POST['idnumber'];
    $mphone = $_POST['mphone'];
    $email = $_POST['email'];
    $pswd = $_POST['pswd'];

    echo "<br>" . $fname;
    echo "<br>" . $lname;
    echo "<br>" . $idnumber;
    echo "<br>" . $mphone;
    echo "<br>" . $email;
    echo "<br>" . $pswd;
