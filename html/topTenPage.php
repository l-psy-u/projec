<?php
// Pagina pubblica: NO session_start()

include("../bd/mysqlcred.php");

$sql = "SELECT nome, punteggio
        FROM utenti
        ORDER BY punteggio DESC
        LIMIT 10";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("<p>Statement preparation failed: " . ($conn->error) . "</p>");
}

$stmt->execute();
$result = $stmt->get_result();

$rows = [];
if ($result) {
    while ($r = $result->fetch_assoc()) {
        $rows[] = $r;
    }
}

$stmt->close();
$conn->close();
?>
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/style6.css">
  <title>Classifica Top 10</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 24px; }
    h1 { margin-bottom: 12px; }
    table { border-collapse: collapse; width: 100%; max-width: 700px; }
    th, td { border: 1px solid #ddd; padding: 10px; }
    th { background: #f5f5f5; text-align: left; }
    .rank { width: 70px; text-align: center; }
    .score { width: 140px; text-align: right; }
  </style>
</head>
<body>
  <div>
    <h1>Top 10 Giocatori 🏆 </h1> 
    <a href="./index.php">Torna alla Home</a>    
  </div>
  

<?php if (count($rows) === 0): ?>
  <p>Nessun giocatore trovato.</p>
<?php else: ?>
  <table>
    <thead>
      <tr>
        <th class="rank">#</th>
        <th>Nome</th>
        <th class="score">Punteggio</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($rows as $i => $r): ?>
        <tr>
          <td class="rank"><?php echo $i + 1; ?></td>
          <td><?php echo ($r["nome"] ?? ""); ?></td>
          <td class="score"><?php echo ($r["punteggio"] ?? 0); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

</body>
</html>