<?php
include "privatePHP.php";
?>

<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="../../css/style.css">
  <title>Cambia password</title>
</head>
<body>
  <div class="container">
    <header>
      <div>
        <h1>Cambia password</h1>
        <h6 class="hint">Inserisci la tua password attuale e la nuova password che desideri impostare.</h6>
      </div>

      <div class="links">
        <a href="./privIndex.php">Home</a>
        <a href="./setup.php">Modifica utente</a>
      </div>
    </header>

    <section class="container">
      <form method="post" action="../../php/update_password.php" autocomplete="off" id="changePasswordForm">
  <label for="current">Password attuale</label>
  <input type="password" id="current" name="current" placeholder="Password attuale" required />

  <label for="pass">Nuova password</label>
  <input type="password" id="pass" name="pass" placeholder="Nuova password" required />

  <label for="confirm">Conferma nuova password</label>
  <input type="password" id="confirm" name="confirm" placeholder="Ripeti la nuova password" required />

  <div id="error"></div>

  <div class="actions">
    <button type="submit">Cambia password</button>
    <button type="reset">Svuota</button>
  </div>
</form>
    
    </section>
  </div>
</body>
<script src="../../script/updatePass.js"></script>
</html>