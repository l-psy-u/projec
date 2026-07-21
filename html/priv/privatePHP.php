<?php
session_start();

// Protezione pagina privata
if (empty($_SESSION["email"])) {
    header("Location: ../logPage.php");
    die();
}

$email = $_SESSION["email"];

include "../../bd/mysqlcred.php";

$nome = "";
$cognome = "";
$descrizione = "";
$citta = "";
$link = "";
$punteggioDB = 0;

if (isset($conn) && !$conn->connect_error) {
    $stmt = $conn->prepare("
        SELECT nome, cognome, descrizione, citta, link, COALESCE(punteggio,0)
        FROM utenti
        WHERE email = ?
        LIMIT 1
    ");

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($nome, $cognome, $descrizione, $citta, $link, $punteggioDB);
        $stmt->fetch();
        $stmt->close();

        // aggiorno anche la sessione
        $_SESSION["nome"] = $nome;
        $_SESSION["cognome"] = $cognome;
        $_SESSION["descrizione"] = $descrizione;
        $_SESSION["citta"] = $citta;
        $_SESSION["link"] = $link;
    }

    $conn->close();
}
?>