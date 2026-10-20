<?php
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'test';
// quan andrebbelo le altr cedenziali pel accedere al sito
  
    // $db_host = "localhost";
    // $db_user = "s67676767";
    // $db_pass = "6767676";
    // $db_name = "67676767";

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    if(mysqli_connect_errno()) {
        echo 'Connection failed: ' . mysqli_connect_error();
        exit();
    }

?>