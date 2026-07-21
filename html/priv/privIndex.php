<?php 
include "privatePHP.php"; 
?>
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Area Privata</title>
  <link rel="stylesheet" href="../../css/style6.css" />
  <!-- <link rel="stylesheet" href="/../../projec/css/style6.css"> -->
</head>

<body>
  <main class="app">
    <header class="top">
      <h1>Area <?php echo ($nome); ?></h1>
      <p class="subtitle">
        Utente: <b><?php echo ($nome . " " . $cognome); ?></b> —
        Email: <b><?php echo ($email); ?></b>
      </p>
      Vittorie totali registrate: <b><span id="dbWins"><?php echo (int)$punteggioDB; ?></span></b>

      <p class="subtitle">
      </p>
<!-- <p>Vittorie totali salvate: <b><span id="dbWins"><?php echo (int)$punteggioDB; ?></span></b></p> -->

      <nav>
        <a href="../../php/logout.php">Logout</a>
        <a href="./profiloPage.php">Profilo</a>
        <a href="./setup.php">setup</a>
        <a href="./changePassword.php">Cambia Password </a>
        <a href="./deletePage.php">Elimina Account</a>
        <a href="./privIndex2.php">gioco 2</a>
      </nav>
    </header>
</body>
  <!-- Passo al JS l'endpoint per salvare le vittorie -->
  <!-- <script>
    window.UPDATE_SCORE_URL = "../../php/updateScore.php";
  </script> -->

  <!-- <script src="../../script/game-script.js"></script> -->
</html>
