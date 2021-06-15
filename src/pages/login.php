<?php
        $titre = "Connectez-vous";
        require "../../src/common/template.php";
        require "../../src/fonctions/dbAccess.php";
        $mdpNok = false;
        require "../../src/fonctions/mesFonctions.php";
        require "../../src/fonctions/dbFonction.php";

    //si mon user est connecté, je le renvoie sur l'accueil grâce à ma fonction
    estConnecte();

    //traitement du formulaire
    if(isset($_POST["login"]) && isset($_POST["mdp"])){
        $login = htmlspecialchars($_POST["login"]);
        $mdp = htmlspecialchars($_POST["mdp"]);

        //Mes données sont sécurisées, je peux appeler ma focntion  pour connecter mon user
        login($login,$mdp);
    }else{
        ?>
        <section class="register">
            <form action="../../src/pages/login.php" method="post" class="login">
            <?php
                if(isset($_GET["erreur"])){
                    ?>
                        <h2><?=$_GET["erreur"]?></h2>
                    <?php
                }
            ?>
                <table>
                    <thead>
                        <tr>
                            <th colspan="2">Connectez-vous</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Login :</td>
                            <td><input type="text" name="login" require placeholder="Entrez votre login"></td>
                        </tr>
                        <tr>
                            <td>Mot de passe :</td>
                            <td><input type="password" name="mdp" require placeholder="Entrez votre mot de passe"></td>
                        </tr>
                        <tr>
                            <td><input type="submit" value="Connectez-vous"></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </section>
        <?php
    }
?>



<?php
    require "../../src/common/footer.php";
?>