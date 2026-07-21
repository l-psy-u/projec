<?php
session_start();

if (empty($_SESSION["email"])) {
    echo "Utente non autenticato.";
    exit();
}

if (
    empty($_POST["pass"]) ||
    empty($_POST["confirm"])
) {
    echo "Impossibile completare l'operazione.";
    exit();
}

$email = $_SESSION["email"];
$pass = trim($_POST["pass"]);
$conf = trim($_POST["confirm"]);

if ($pass !== $conf) {
    echo "Impossibile completare l'operazione.";
    exit();
}

include "../bd/mysqlcred.php";

if (!isset($conn) || $conn->connect_error) {
    echo "Errore durante l'operazione.";
    exit();
}

$stmt = $conn->prepare("SELECT password FROM utenti WHERE email = ? LIMIT 1");
if (!$stmt) {
    echo "Errore durante l'operazione.";
    $conn->close();
    exit();
}

$stmt->bind_param("s", $email);
$stmt->execute();

$password_db = "";
$user = false;
//Prende la riga trovata come array associativo e salva la password hash.
if (function_exists("mysqli_stmt_get_result")) {
    $res = $stmt->get_result();
    if ($res && $res->num_rows === 1) {
        $row = $res->fetch_assoc();
        $password_db = $row["password"];
        $user = true;
    }
} else {
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($password_db);
        $stmt->fetch();
        $user = true;
    }
}

$stmt->close();

if (!$user || !password_verify($pass, $password_db)) {
    $conn->close();
    echo "Impossibile completare l'operazione.";
    exit();
}

$stmt = $conn->prepare("DELETE FROM utenti WHERE email = ?");
if (!$stmt) {
    $conn->close();
    echo "Errore durante l'operazione.";
    exit();
}

$stmt->bind_param("s", $email);

if ($stmt->execute() && $stmt->affected_rows === 1) {
    $stmt->close();
    $conn->close();

    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
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

    echo "ok";
    exit();
}

$stmt->close();
$conn->close();

echo "Errore durante l'operazione.";
exit();
?>