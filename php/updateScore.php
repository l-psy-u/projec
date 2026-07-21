<?php
session_start();
header("Content-Type: application/json");

if (empty($_SESSION["email"])) {
    echo json_encode(["ok" => false, "message" => "Utente non autenticato"]);
    exit();
}

$input = json_decode(file_get_contents("php://input"), true);

if (!is_array($input) || !isset($input["delta"])) {
    echo json_encode(["ok" => false, "message" => "Dati mancanti"]);
    exit();
}

$delta = filter_var($input["delta"], FILTER_VALIDATE_INT);

if ($delta === false || $delta <= 0 || $delta > 200) {
    echo json_encode(["ok" => false, "message" => "Punteggio non valido"]);
    exit();
}

if (!empty($_SESSION["score_saved"])) {
    echo json_encode(["ok" => false, "message" => "Punteggio già salvato"]);
    exit();
}

include "../bd/mysqlcred.php";

if (!isset($conn) || $conn->connect_error) {
    echo json_encode(["ok" => false, "message" => "Errore database"]);
    exit();
}

$email = $_SESSION["email"];

$stmt = $conn->prepare("
    UPDATE utenti
    SET punteggio = COALESCE(punteggio, 0) + ?
    WHERE email = ?
");

if (!$stmt) {
    echo json_encode(["ok" => false, "message" => "Errore query"]);
    $conn->close();
    exit();
}

$stmt->bind_param("is", $delta, $email);

if (!$stmt->execute()) {
    echo json_encode(["ok" => false, "message" => "Errore salvataggio"]);
    $stmt->close();
    $conn->close();
    exit();
}

$stmt->close();

$_SESSION["score_saved"] = true;

$stmt = $conn->prepare("SELECT COALESCE(punteggio,0) AS punteggio FROM utenti WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
$row = $res ? $res->fetch_assoc() : null;

echo json_encode([
    "ok" => true,
    "message" => "Punteggio salvato",
    "punteggio" => (int)($row["punteggio"] ?? 0)
]);

$stmt->close();
$conn->close();
exit();
?>