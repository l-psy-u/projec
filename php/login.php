<?php
session_start();
// salvo i dati e tolgo gli spazzi 

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Richiesta non valida.";
    exit();
}
$email = trim($_POST["email"] ?? "");
$pass  = $_POST["pass"] ?? "";
    
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email o password non validi.";
        exit();
}

if ($email === "" || $pass === "") {
    echo "Compila tutti i campi.";
    exit();
}

include "../bd/mysqlcred.php";

if (!isset($conn) || $conn->connect_error) {
    echo "Errore connessione database.";
    exit();
}

$sql = "SELECT nome, cognome, email, password, punteggio, descrizione, citta, link
        FROM utenti
        WHERE email = ?";

// evito l injection
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Errore query database.";
    exit();
}
//collega la variabile mail al ? della query
$stmt->bind_param("s", $email);
$stmt->execute();

$user = null;

if ($stmt->execute()) {
    $res = $stmt->get_result();// prendo il risultato 
    $user = $res ? $res->fetch_assoc() : null;// trafroma in arrau
}
// } else {
//     $stmt->store_result();// salvo il risultato

//     if ($stmt->num_rows === 1) {
//         $stmt->bind_result($nome, $cognome, $emailDb, $pswHash, $punteggio, $descrizione, $citta, $link);
//         $stmt->fetch();

//         $user = [
//             "nome" => $nome,
//             "cognome" => $cognome,
//             "email" => $emailDb,
//             "password" => $pswHash,
//             "punteggio" => $punteggio,
//             "descrizione" => $descrizione,
//             "citta" => $citta,
//             "link" => $link
//         ];
//     }
// }

if (!$user || !password_verify($pass, $user["password"])) {
    $stmt->close();
    $conn->close();

    echo "Email o password non validi.";
    exit();
}

session_regenerate_id(true);

$_SESSION["nome"]      = $user["nome"];
$_SESSION["cognome"]   = $user["cognome"];
$_SESSION["email"]     = $user["email"];
$_SESSION["punteggio"] = (int)$user["punteggio"];
$_SESSION["descrizione"] = $user["descrizione"];
$_SESSION["citta"] = $user["citta"];
$_SESSION["link"] = $user["link"];

$stmt->close();
$conn->close();

echo "ok";
exit();