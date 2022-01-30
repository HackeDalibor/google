<?php
    session_start();

    require('src/connectdb.php');
    // Nécessaire pour se connecter à la base de données

    // Les 3 champs doivent être renseignés pour faire une inscription d'utilisateur
    if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_pass'])) {

        // Si les champs du formulaire ne sont pas vides alors on peut traîter la demande

        // Variables
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $confirm_pass = htmlspecialchars($_POST['confirm_pass']);

        $mdphash = password_hash($password, PASSWORD_DEFAULT);

        // htmlspecialchars est une fonction PHP qui permet de convertir les caractères spéciaux en entités html

        // htmlspecialchars(); convert special html symbols to special chars...

        // les filtres sont utilisés pour valider les données

        // Cela permet de nous prémunir des failles XSS, que l'on verra en formation diplomante


        // On vérifie que le format donné dans le champ email correspond à un format email

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            
            header('location:signup.php?message=Veuillez indiquer un email valide');
            exit();
        }


        // Vérification de la concordance des deux mots de passe
    
        if($password != $confirm_pass) {

            header('location:signup.php?error=1&message=Vos mots de passe ne sont pas identiques.');
            exit();
        }


        // Email déjà utilisé
        
        // Faire une requête pour savoir combien d'email j'ai qui correspondent à l'email donné par l'utilisateur

        $req = $pdo->prepare("SELECT COUNT(*) as nbMail FROM user WHERE email = ?");
        $req->execute(array($email));
        
        while($email_verification = $req->fetch()){

            // si le nombre d'emails que la requête trouve est différent de zéro, tu me mets un message d'erreur

            if($email_verification['nbMail'] != 0){
                header('location:signup.php?error=1&message=Cet email existe déjà, veuillez essayer un autre');
                exit();
            }
        }

        // ENVOI EN BDD
        $req = $pdo->prepare("INSERT INTO user(email, password) VALUES(?,?)");
        // Prépare une requête SQL à être exécutée par la méthode PDOStatement::execute(). Le modèle de déclaration peut contenir zéro ou plusieurs paramètres nommés (:nom) ou marqueurs (?) pour lesquels les valeurs réelles seront substituées lorsque la requête sera exécutée.
        
        $req->execute(array($email, $mdphash));
        // Exécute une requête préparée.

        // Une requête préparée nous permet de nous prémunir des failles SQL (programme dev)

        header('location:index.php?success=1&message=Vous avez créé un compte');
        exit();

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/pngn" href="img/logo2.png">
    <title>Sign Up</title>
</head>
<body>
    <main>
        <div id="main-body">
            <div>
                <figure>
                    <img src="img/Google_logo.png" alt="Logo google" class="img">
                    <figcaption><h2>Créer votre compte Google</h2></figcaption>
                </figure>

                <?php 

                    if(isset($_GET['success'])){

                        echo '<div class="alert success">'.htmlspecialchars($_GET['message']).'</div>';

                    } else if(isset($_GET['error'])) {

                        echo '<div class="alert error">'.htmlspecialchars($_GET['message']).'</div>';
            
                    }
                    

                ?>

                <form action="signup.php" method="post">
                    <label class="email">
                        <span>Utiliser votre compte Google</span>
                        <input type="email" placeholder="Adresse e-mail ou numéro de téléphone" class="Input" name="email">
                    </label>
                    <div class="passwords">
                        <label class="Password">
                            <input type="password" placeholder="Mot de passe" class="Input" name="password">
                        </label>
                        <label class="Confirm">
                            <input type="password" placeholder="Confirmer" class="Input" name="confirm_pass">
                        </label>
                    </div>
                    <div class="bottom">
                        <a href="index.php" class="create">Se connecter à un compte existant</a>
                        <label>
                            <input type="submit" value="Suivant" class="Submit">
                        </label>
                    </div>
                </form>
            </div>
            <div id="footer-body">
                <figure>
                    <img src="img/account.svg" alt="accshield" class="footer-img">
                    <figcaption>Tout Google avec un seul compte.</figcaption>
                </figure>
                
            </div>
        </div>
    </main>
    <?php
    
    include("src/footer.php"); 

    // Nous permet d'inclure un fichier; si le code ne marche pas dans le fichier indiqué ce fichier va quand même fonctionner contrairement à la fonction require
    
    ?>
</body>
</html>