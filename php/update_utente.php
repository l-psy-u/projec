<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Richiesta non valida.");
}

if (empty($_SESSION["email"])) {
     header("Location: ../html/logPage.php");
    exit();
}

$email = $_SESSION["email"];

$firstname   = isset($_POST["firstname"]) ? trim($_POST["firstname"]) : "";
$lastname    = isset($_POST["lastname"]) ? trim($_POST["lastname"]) : "";
$descrizione = isset($_POST["descrizione"]) ? trim($_POST["descrizione"]) : "";
$citta       = isset($_POST["citta"]) ? trim($_POST["citta"]) : "";
$link        = isset($_POST["link"]) ? trim($_POST["link"]) : "";

if (
    $firstname === "" &&
    $lastname === "" &&
    $descrizione === "" &&
    $citta === "" &&
    $link === ""
) {
    exit("Nessuna modifica inviata.");
}

include_once("../bd/mysqlcred.php");

if (!isset($conn) || $conn->connect_error) {
    exit("Errore di connessione al database.");
}

if (strlen($firstname) > 60) {
    exit("Nome troppo lungo.");
}

if (strlen($lastname) > 60) {
    exit("Cognome troppo lungo.");
}

if (strlen($descrizione) > 500) {
    exit("Descrizione troppo lunga.");
}

if (strlen($citta) > 80) {
    exit("Città troppo lunga.");
}

if ($link !== "" && !filter_var($link, FILTER_VALIDATE_URL)) {
    exit("Link non valido.");
}

if ($firstname !== "") {
    $stmt = $conn->prepare("UPDATE utenti SET nome = ? WHERE email = ?");
    $stmt->bind_param("ss", $firstname, $email);
    $stmt->execute();
    $stmt->close();

    $_SESSION["nome"] = $firstname;
}

if ($lastname !== "") {
    $stmt = $conn->prepare("UPDATE utenti SET cognome = ? WHERE email = ?");
    $stmt->bind_param("ss", $lastname, $email);
    $stmt->execute();
    $stmt->close();

    $_SESSION["cognome"] = $lastname;
}

if ($descrizione !== "") {
    $stmt = $conn->prepare("UPDATE utenti SET descrizione = ? WHERE email = ?");
    $stmt->bind_param("ss", $descrizione, $email);
    $stmt->execute();
    $stmt->close();

    $_SESSION["descrizione"] = $descrizione;
}

if ($citta !== "") {
    $stmt = $conn->prepare("UPDATE utenti SET citta = ? WHERE email = ?");
    $stmt->bind_param("ss", $citta, $email);
    $stmt->execute();
    $stmt->close();

    $_SESSION["citta"] = $citta;
}

if ($link !== "") {
    $stmt = $conn->prepare("UPDATE utenti SET link = ? WHERE email = ?");
    $stmt->bind_param("ss", $link, $email);
    $stmt->execute();
    $stmt->close();

    $_SESSION["link"] = $link;
}

$conn->close();

echo "Profilo aggiornato con successo.";
exit();
?>