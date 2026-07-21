<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Richiesta non valida.");
}
if (empty($_SESSION["email"])) {
    exit("Utente non autenticato.");
}

$email = $_SESSION["email"];

$current = isset($_POST["current"]) ? trim($_POST["current"]) : "";
$pass    = isset($_POST["pass"]) ? trim($_POST["pass"]) : "";
$confirm = isset($_POST["confirm"]) ? trim($_POST["confirm"]) : "";

if ($current === "" || $pass === "" || $confirm === "") {
    exit("Compila tutti i campi.");
}

if ($pass !== $confirm) {
    exit("Le password non coincidono.");
}

if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/", $pass)) {
    exit("La password deve avere almeno 8 caratteri, una maiuscola e un carattere speciale e amiucola.");
}

include_once("../bd/mysqlcred.php");

if (!isset($conn) || $conn->connect_error) {
    exit("Errore di connessione al database.");
}

$stmt = $conn->prepare("SELECT password FROM utenti WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    $conn->close();
    exit("Utente non trovato.");
}

if (!password_verify($current, $user["password"])) {
    $conn->close();
    exit("Password attuale errata.");
}

$new_hash = password_hash($pass, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE utenti SET password = ? WHERE email = ?");
$stmt->bind_param("ss", $new_hash, $email);
$stmt->execute();
$stmt->close();

$conn->close();

echo "Password aggiornata con successo.";
exit();

?>