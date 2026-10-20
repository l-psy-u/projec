<?php
include "privatePHP.php";
?>

<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Modifica utente</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
  <div class="container">
    <header>
      <div id="updateMessage" style="display:none; font-weight:bold; margin:10px 0; text-align:center;"></div>
      <div>
        <h1>Modifica utente</h1>
        <p class="hint">Aggiorna nome, cognome, descrizione, città e link.</p>
      </div>
      
      <div class="links">
        <a href="./privIndex.php">Home</a>
      </div>
    </header>
    
    <section class="container">
      <form method="post" action="../../php/update_utente.php" autocomplete="off" id=updateForm>
        
        <div class="container">
    
    <label for="firstname">Nome corrente: <?php echo ($nome) ;if($nome==="") {
            echo " (vuoto)";
          } ?></label>
    <input type="text" id="firstname" name="firstname" placeholder="Nuovo nome">
      </div>
        <div class="container">
          <label for="lastname">Cognome corrente: <?php echo ($cognome); if($cognome==="") {
            echo " (vuoto)";
          } ?></label>
          <input type="text" id="lastname" name="lastname" placeholder="Nuovo cognome">
        </div>

        <div class="container">
          <label for="descrizione">Descrizione corrente: <?php echo ($descrizione); if($descrizione==="") {
            echo " (vuoto)";
          } ?></label>
          <textarea id="descrizione" name="descrizione" placeholder="Scrivi una breve descrizione"></textarea>
        </div>

        <div class="container">
          <label for="citta">Città corrente: <?php echo ($citta); if($citta==="") {
            echo " (vuoto)";
          } ?>
        </label>
          <input type="text" id="citta" name="citta" placeholder="La tua città">
        </div>

        <div class="container">
          <label for="link">Link corrente: <?php echo ($link);
          if($link==="") {
            echo " (vuoto)";

          } ?>
          </label>
          <input type="url" id="link" name="link" placeholder="https://...">
        </div>

        <div  class="container">
          <button type="submit">Salva dati</button>
          <button type="reset" class="ghost">Svuota</button>
        </div>

      </form>
    </section>
  </div>
</body>
<script src="../../script/update-profile.js"></script>
</html>