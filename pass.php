<?php
    session_start();

    require('src/connectdb.php');
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/pngn" href="img/logo2.png">
    <title>Accueil</title>
</head>
<body>
    <main>
        <div id="main-body">
                <figure>
                    <img src="img/Google_logo.png" alt="Logo google" class="img">
                    <figcaption><h2>Vous êtes connecté(e)</h2></figcaption>
                </figure>
                <form action="#" class="pass" method="post">
                    <span><?php echo $_SESSION['email']; ?></span>
                    <div class="bottom">
                        <a href="logout.php">Log out</a>
                    </div>
                </form>
            </div>
    </main>

    <?php include("src/footer.php"); ?>
</body>
</html>