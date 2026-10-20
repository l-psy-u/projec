<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Registrati</title>
</head>
<body>
    <h1>Registrati</h1>
    
    <section class="grid container">

        <section class="middle">
            <form action="../php/Registration.php" method="post" id="registration" class="container">
                <fieldset>    
                    <legend> <h3> Registrati </h3> </legend>

                    <input type="text" id="nome" name="nome"  placeholder="nome"> <br><br>
                    <input type="text" id="cognome" name="cognome"  placeholder="cognome"> <br><br>

                    <input type="email" id="email" name="email"  placeholder="email"> <br><br>
                    <input type="password" id="pass" name="pass"  placeholder="choose your password"> <br><br>
                    <input type="password" id="confirm" name="confirm"  placeholder="confirm your password"> <br><br>

                    <input type="submit" id="submit" name="submit" value="Premi per registrarti"><br><br>
                    <div id="registrationError"></div>
                    <div id="registrationMessage" style="display: none;"></div>
                </fieldset>
            </form>
            <p><a href="./logPage.php"> hai gi aun account?</a></p>
        </section>
    </section>
</body>
<script src="../script/registrazione.js"></script>
</html>
