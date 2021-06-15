<?php
    $titre = "Votre compte";
    require "../../src/common/template.php";
    require "../../src/fonctions/dbAccess.php";
    require "../../src/fonctions/dbFonction.php";
    require "../../src/fonctions/mesFonctions.php";    
    
    // traitement du formulaire
    if(isset($_FILES["fichier"]) && !empty($_FILES["fichier"])){
        //appelle a fonction sendImg
        $photo = sendImg($_FILES["fichier"], "avatar");
        //Updater l'adresse du nouvel avatar dans ma DB
        updateImg($photo);
        //effacer la photo de l'avatar de l'utilisateur si celui-çi a déjà un avatar personnalisé
        if($_SESSION["user"]["photo"] != "../../src/img/site/defaut_avatar.png"){
            //Effacer l'avatar précédent de mon user
            unlink($_SESSION["user"]["photo"]);
        }
        //Je réattribue le chemin du nouvel avatar dans mon $_SESSION["user]
        $_SESSION["user"]["photo"] = $photo;
         header("location: ../../src/pages/account.php?maj=true&message=Félicitation votre avatar est mise à jour");
        exit();
    }
?> 

<section id="account">
    <div class="account">
        <div class="infosMembre p-2">
            <a href="../../src/pages/account.php?edit=true"><img title="Cliquez pour changer votre avatar" src="<?=$_SESSION["user"]["photo"]?>" alt="avatar du membre"></a>
            <!-- Si mon user a cliqué sur l'image je fais apparaitre un formulaire  -->
            <?php 
                if(isset($_GET["edit"]) && $_GET["edit"]==true){
                    ?>
                        <form action="../../src/pages/account.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="fichier">
                        <input type="submit" value="Envoyez votre avatar">
                        </form>
                    <?php
                    //Si la maj image est réussie, afficher le message
                    if(isset($_GET["maj"]) && $_GET["maj"]==true)
                    {
                        echo "<h3>" . $_GET["message"] . "</h3>";
                    }
                }
                //Message pour féliciter l'upload du formulaire
            ?>
            <table>
            <tr>
                <td>Pseudo :</td>
                <td><?=$_SESSION["user"]["login"]?></td>
            </tr>
            <tr>
                <td>Nom :</td>
                <td><?=$_SESSION["user"]["nom"]?></td>
            </tr>
            <tr>
                <td>Prénom :</td>
                <td><?=$_SESSION["user"]["prenom"]?></td>
            </tr>
            <tr>
                <td>Statut :</td>
                <td><?=$_SESSION["user"]["role"]?></td>
            </tr>
            </table>
        </div>
        <div class="contenuMembre p-2">
            <?php
            // Si le user est au moins auteur, j'affiche une liste de ses articles
                if($_SESSION["user"]["role"]== "auteur" || $_SESSION["user"]["role"]== "admin")
                {?>
                    <h2>Vos articles</h2>
                    <p>Pas d'article</p>
                <?php
                }
            ?>
            <h2>Vos commentaires</h2>
            <p>Pas de commentaires</p>
        </div>

    </div>
</section>

<?php
    
    require "../../src/common/footer.php";
?>