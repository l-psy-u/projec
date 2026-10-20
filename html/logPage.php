<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    
    <div id="loginMessage" >  </div>
  
    <div class= "container">
        <h1>Carta,forbici,sasso </h1>
        <h2>Use your email and password to access.</h2>
        <nav>
        <a href="./index.php">Home</a>
        <div id="loginMessage" >
            </div  class ="container">
        <a href="RegPage.php"> Registrati </a>
        </nav>
    </div>
</div>
        <section class= "container">
            <form action ="../php/login.php" method="POST" id="login" class ="container">
                <fieldset>    
                    <legend> <h3><b> LogIn </b> </h3> </legend>
                    <input type="email" id="email" name="email" placeholder="Email" value="" autocomplete="email"> <br><br>
                    <input type="password" id="pass" name="pass" placeholder="Password" value="" autocomplete="current-password"> <br><br>
                    <input type="submit" name="submit" value="LogIn"> <br><br>
                    <div id="loginError"></div>
                </fieldset>
            </form>
        </section>
    
    
    <footer class = "container">
        <p>And in the end, the love you take is equal to the love you make</p>
    </footer>
</body>
<script src="../script/login2.js"></script>
</html>