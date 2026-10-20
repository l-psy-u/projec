<?php 
include "privatePHP.php"; 
unset($_SESSION["score_saved"]);
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Gioco SAW</title>

  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

    <h1>Gioco SAW</h1>
    <p>Comandi: ← → per muoverti, SPAZIO per sparare</p>
    <header class="top">
        <h1>Area <?php echo ($nome); ?></h1>
        <p class="subtitle">
            Utente: <b><?php echo ($nome . " " . $cognome); ?></b> —
            Email: <b><?php echo ($email); ?></b>
        </p>
        Vittorie totali registrate: <b><span id="dbWins"><?php echo (int)$punteggioDB; ?></span></b>
        <a href="./privIndex.php">torna al gioco 1</a>
        
      <p class="subtitle">
      </p>
</header>


<canvas id="gameCanvas" width="600" height="700"></canvas>
<script src="../../script/gioco2.js"></script>

</body>
</html>