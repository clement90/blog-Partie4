<?php

    $titre = "Enregistrez-vous";
    require "../../src/common/template.php";
    require "../../src/fonctions/dbAccess.php";
    require "../../src/fonctions/mesFonctions.php";
    require "../../src/fonctions/dbFonction.php";

    //si mon user est connecté, je le renvoie  sur la page d'acceuil grace a ma fonction
    estConnecte();

    //Définir la variable qui marquera si le mdp est correcte ou pas
    if(isset($_SESSION["mdpNok"]) && $_SESSION["mdpNok"] == true){
        $mdpNok = $_SESSION["mdpNok"];
        $_SESSION["mdpNok"] = false;
    }else{
        $mdpNok = false;
    }
?>

<?php 
    // Vérifier si les input sont bien présent( et donc que ma méthode POST a été déclenchée)
    if(isset($_POST["nom"]) && !empty($_POST["nom"]) && !empty($_POST["login"])
        && !empty($_POST["prenom"]) && !empty($_POST["email"]) 
        && !empty($_POST["mdp"]) && !empty($_POST["mdp2"])){

            //si l'avatar du user est vide, j'utiliserai l'avatar par défaut
            $photo= "../../src/img/site/defaut_avatar.png";

            // Sanétiser mes données
            //Je construit un tableau avec les données recues
            $option = array(
                "nom" => FILTER_SANITIZE_STRING,
                "prenom" => FILTER_SANITIZE_STRING,
                "login" => FILTER_SANITIZE_STRING,
                "email" => FILTER_VALIDATE_EMAIL,
                "mdp" => FILTER_SANITIZE_STRING,
                "mdp2" => FILTER_SANITIZE_STRING
            );

            //Créer un variable result qui va accueillir les données saines
            $result = filter_input_array(INPUT_POST, $option);

            $nom = $result["nom"];
            $prenom = $result["prenom"];
            $login = $result["login"];
            $email = $result["email"];
            $mdp = $result["mdp"];
            $mdp2 = $result["mdp2"];
            $role = 4;

            // Vérifier si les mdp sont identique
            if($mdp == $mdp2)
            {
                // hash du mdp
                $mdpHash = md5($mdp);
                // générer grain de sel
                $sel = grainDeSel(rand(5,20));
                // mot de passe a envoyer
                $mdpToSend = $mdpHash . $sel;
                $mdpNok = false;
            }
            else
            {
                // booléen de contrôle
                $mdpNok = true;
                // J'active  une session  pour indiquer que mdp sont noOk 
                $_SESSION["mdpNok"]= true;
                // je recharge ma page
                header("location: ../../src/pages/register.php");
                exit();
            }

            // Vérifier si le user ou le mail n'est pas présent dans ma DB
            $bdd = new PDO("mysql:host=localhost;dbname=blog-gaming;charset=utf8", "root", "");
            
            //check login
            $requete = $bdd->prepare("SELECT COUNT(*) AS x 
                                        FROM users
                                        WHERE login = ?");
            $requete->execute(array($login));

            while($result = $requete->fetch())
            {
                if($result["x"] != 0){
                    $_SESSION["msgLogin"]= true;
                    header("location: ../../src/pages/register.php");
                    exit();
                }

            }

            // check mail
            $requete = $bdd->prepare("SELECT COUNT(*) AS x 
                                        FROM users
                                        WHERE email = ?");
            $requete->execute(array($email));

            while($result = $requete->fetch())
            {
                if($result["x"] != 0){
                    $_SESSION["msgEmail"]= true;
                    header("location: ../../src/pages/register.php");
                    exit();
                }

            }

            // Vérifeir si user a envoyer photo et agir en conséquence
            if(isset($_FILES["fichier"]) &&  $_FILES["fichier"]["error"]==0){
                $photo = sendImg($_FILES["fichier"], "avatar");
            }

            //Mes données sont correctes, elles sont saines, je peux créer mon user
            createUser($photo, $login, $nom, $prenom, $email,$mdpToSend, $role, $sel);
            
            // Tout s'est bien passé, invite user à se connecter
            ?>
            <h2 class="registerOk">Votre compte est maintenant créé, vous pouvez vous <a href="../../src/pages/login.php">CONNECTER</a></h2>


<?php
        }
        else
        {

?>

<section class="register">
<form action="" method="post" enctype="multipart/form-data" class="login">   
    <?php
        // Si les booléen de checkmail est true, afficher infomration pour inviter a connecter
        if(isset($_SESSION["msgEmail"])&&$_SESSION["msgEmail"] == TRUE)
        {
            echo "<h2>Cet email possède déjà un compte, veuillez vous connecter</h2>";
            $_SESSION["msgEmail"] = false;
        }
        // Si les booléen de checkLogin est true, afficher infomration pour inviter a connecter
        if(isset($_SESSION["msgLogin"])&&$_SESSION["msgLogin"] == TRUE)
        {
            echo "<h2>Ce login possède déjà un compte, veuillez vous connecter</h2>";
            $_SESSION["msgLogin"] = false;
        }

        if($mdpNok==TRUE){
            echo "<h2>Les mot de passe ne sont pas identique</h2>";
            $mdpNok = FALSE;
        }
    ?>
    <table>
        <thead>
            <tr>
                <th colspan="2">Créer votre compte</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Prénom :</td>
                <td><input type="text" name="prenom" required placeholder="Entrez votre prénom"/></td>
            </tr>
            <tr>
                <td>Nom :</td>
                <td><input type="text" name="nom" required placeholder="Entrez votre nom"/></td>
            </tr>
            <tr>
                <td>Login :</td>
                <td><input type="text" name="login" required placeholder="Entrez votre login"/></td>
            </tr>
            <tr>
                <td>Email :</td>
                <td><input type="email" name="email" required placeholder="Entrez votre email"/></td>
            </tr>
            <tr>
                <td>Mot de passe :</td>
                <td><input type="password" name="mdp" required placeholder="Entrez votre mot de passe" /></td>
            </tr>
            <tr>
                <td>Mot de passe :</td>
                <td><input type="password" name="mdp2" required placeholder="Répétez votre mot de passe" /></td>
            </tr>
            <tr>
                <td>Envoyer votre avatar :</td>
                <td><input type="file" name="fichier"/></td>
            </tr>
            <tr>
                <td><input type="submit" value="Créer votre compte"/></td>
            </tr>
        </tbody>
    </table>
</form>
</section>

<?php
        }
    require "../../src/common/footer.php";
?>