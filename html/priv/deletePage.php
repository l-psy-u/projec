<?php
include "privatePHP.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
<a href="./privIndex.php">Torna indietro</a>
<p>Inserisci password</p>
<form action="../../php/delete.php" method="POST">
    <p>Email: <?php echo ($email); ?></p>
    <!-- <input type="email" name="email" placeholder="Email" required> -->
    <input type="password" name="pass" placeholder="Password" required>
    <input type="password" name="confirm" placeholder="Confirm Password" required>
    <button type="submit">Elimina account</button>
    </form>
    </div>
</body>
</html>