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

</head>

<body>
    <header class="top">
      <h1>Area <?php echo ($nome); ?></h1>
      <p class="subtitle">
        Utente: <b><?php echo ($nome . " " . $cognome); ?></b> —
        Email: <b><?php echo ($email); ?></b>
        descrizione: <b><?php echo ($descrizione); ?></b>
        citta: <b><?php echo ($citta); ?></b>
        punti: <b><?php echo (int)($punteggioDB); ?></b>
        link: <b><?php echo ($link); ?></b>

    </p>
      Vittorie: <b><span id="dbWins"><?php echo (int)$punteggioDB; ?></span></b>
  
      <p class="subtitle">
      </p>
<!-- <p>Vittorie totali salvate: <b><span id="dbWins"><?php echo (int)$punteggioDB; ?></span></b></p> -->
      <nav>
        <a href="./privIndex.php">Home</a>
        <!-- <a href="../game.php">Game (pubblico)</a> -->
        <a href="../../php/logout.php">Logout</a>
        <a href="./profiloPage.php">Profilo</a>
        <!-- <a href="./setup.php">setup</a> -->
        <!-- <a href="./privIndex2.php">GIOCO </a> -->
        <!-- <a href="./privIndex.php">home</a> -->
      </nav>
    </header>


</body>
  <!-- <script src="../../script/game-script.js"></script> -->
</html>
