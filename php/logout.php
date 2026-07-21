<?php
   session_start();
   // svuoto array
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    // prendo i paramaetri
    $params = session_get_cookie_params();
    //cancello
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
        );
        }
        
session_destroy();
header("Location: ../html/index.php");
exit();
?> 