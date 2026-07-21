<?php

if (
    empty($_POST["nome"]) || empty($_POST["cognome"]) ||
    empty($_POST["email"]) || empty($_POST["pass"]) || empty($_POST["confirm"])
) {
    echo "pippo";
    exit();
}

$nome    = trim($_POST["nome"]);
$cognome = trim($_POST["cognome"]);
$email   = trim($_POST["email"]);
$pass    = trim($_POST["pass"]);
$conf    = trim($_POST["confirm"]);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "MAIL NON VALIDA";
    exit();
}

if ($pass !== $conf) {
    echo "PASSWORD DIVERSE";
    exit();
}

if (!preg_match("/^(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/", $pass)) {
    echo "PASSWORD non valida";
    exit();
}

$hash_password = password_hash($pass, PASSWORD_DEFAULT);

include "../bd/mysqlcred.php";

if (!isset($conn) || $conn->connect_error) {
    echo "Errore durante la registrazione";
    exit();
}

$descrizione = "";
$citta = "";
$link = "";

$stmt = $conn->prepare(
    "INSERT INTO utenti (nome, cognome, email, password, punteggio, descrizione, citta, link)
     VALUES (?, ?, ?, ?, 0, ?, ?, ?)"
);

if (!$stmt) {
    echo "Errore durante la registrazione";
    $conn->close();
    exit();
}

$stmt->bind_param("sssssss", $nome, $cognome, $email, $hash_password, $descrizione, $citta, $link);

if ($stmt->execute()) {
    echo "ok";
} else {
    echo "Impossibile completare la registrazione con i dati forniti";
}

$stmt->close();
$conn->close();
exit();
?>