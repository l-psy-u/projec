<?php
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'test';
// quan andrebbelo le altr cedenziali pel accedere al sito
  
    // $db_host = "localhost";
    // $db_user = "s4635523";
    // $db_pass = "1;monocromo.";
    // $db_name = "s4635523";

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    if(mysqli_connect_errno()) {
        echo 'Connection failed: ' . mysqli_connect_error();
        exit();
    }

?>