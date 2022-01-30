<?php
    session_start();

    require('src/connectdb.php');
    // require est identique à include mis à part le fait que lorsqu'une erreur survient, il produit également une erreur fatale de niveau E_COMPILE_ERROR.

    if(!empty($_POST['email']) && !empty($_POST['password'])) {
        // Si les champs du formulaire ne sont pas vides alors on peut traîter la demande

        // empty - Détermine si une variable est vide

        // ! - détermine l'invers de notre requête
        
        // $_POST est un tableau associatif des valeurs passées au script courant via le protocole HTTP et la méthode POST lors de l'utilisation de la chaîne application/x-www-form-urlencoded ou multipart/form-data comme en-tête HTTP Content-Type dans la requête.

        // Variables

        $email = htmlspecialchars($_POST['email']);
        // htmlspecialchars convertit les caractères spéciales en entités HTML
        $password = htmlspecialchars($_POST['password']);
        // Vérification syntaxe de l'adresse email


        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // filter_var = filtre une variable avec un filtre spécifique
            // FILTER_VALIDATE_EMAIL valide une adresse mail


            header('location:index.php?error=1&message=Votre email est invalide.');
            exit();
        }


        // Connexion au site

        $req = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        // prepare = prépare une requête à l'exécution et retourne un objet
        $req->execute(array($email));
        // execute = exécute une requête préparée

        while($user = $req->fetch()) {
            // fetch récupère la ligne suivante d'un jeu de résultats PDO


            
            if(password_verify($password, $user['password'])) {
        
            // if($password == $user['password']) {
            // Si le mot de passe donné dans le formulaire correspond au mot de passe de l'utilisateur en base de données

            
                $_SESSION['connect'] = 1;
                $_SESSION['email'] = $user['email'];
                // $_SESSION = Un tableau associatif des valeurs stockées dans les sessions, et accessible au script courant, c'est aussi une 'superglobale'.

            } else {


                header('location:index.php?error=1&message=Votre mot de passe ne correspond pas.');
                exit();

            }
        }
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
    <title>Login</title>
</head>
<body>
    <main>

        <?php
            if(!isset($_SESSION['connect'])) {
            // isset - Détermine si une variable est déclarée et est différente de null
        ?>

            <div id="main-body">
                <figure>
                    <img src="img/Google_logo.png" alt="Logo google" class="img">
                    <figcaption><h2>Connexion</h2></figcaption>
                </figure>
                <form action="index.php" method="post">
                    <label class="email">
                        <span>Utiliser votre compte Google</span>
                        <?php 

                            if(isset($_GET['success'])) {

                                echo '<div class="alert success">'.htmlspecialchars($_GET['message']).'</div>';

                            } else if(isset($_GET['error'])) {

                                echo '<div class="alert error">'.htmlspecialchars($_GET['message']).'</div>';

                            }

                        ?>
                        <input type="email" placeholder="Adresse e-mail ou numéro de téléphone" class="Input" name="email">
                    </label>
                    <label class="email">
                        
                        <!-- <p class="paragraph">Pour continuer, veuillez confirmer votre identité</p> -->

                        <input type="password" placeholder="Veuillez saisir votre mot de passe" class="Input" name="password">

                    </label>
                    <div class="invited">
                        <p  style="margin-bottom: 50px;">S'il ne s'agit pas de votre ordinateur, utilisez le mode Invité pour vous connecter en mode privé. 
                        <a href="#" class="create"> En savoir plus</a></p>
                    </div>
                    <div class="bottom">
                        <a href="signup.php" class="create">Créer un compte</a>
                        <label>
                            <input type="submit" value="Suivant" class="Submit">
                        </label>
                    </div>
                </form>
            </div>

        <?php } else { 
            
            
                header('location:pass.php');


            }
            
        ?>

            <!-- <div id="main-body">
                <figure>
                    <img src="img/Google_logo.png" alt="Logo google" class="img">
                    <figcaption><h2>Bienvenue</h2></figcaption>
                </figure>
                <form action="#" method="post">
                    <span class="show-email"><p> echo $_SESSION['email'];</p></span>
                    <!-- Fonction nous permettant d'afficher un contenu qui se trouve dans la session(ici ça sera l'email, le span et le p ne sont pas obligatoires) -->
                    
                    <!-- <div class="bottom">
                        <a href="#" class="create">Vous avez oublié votre mot de passe ?</a>
                        <label>
                            <input type="submit" value="Suivant" class="Submit">
                        </label>
                        <a href="logout.php" class="create"><strong>Retour</strong></a>
                    </div>
                </form>
            </div> -->

    </main>
    <?php include("src/footer.php"); ?>
</body>
</html>