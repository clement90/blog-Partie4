<?php
$titre = "Espace d'administration";
require "../../src/common/template.php";
require "../../src/fonctions/dbAccess.php";
require "../../src/fonctions/dbFonction.php";
require "../../src/fonctions/mesFonctions.php";

// refuser l'accès à la page  aux personnes qui ne sont pas admin
if($_SESSION["user"]["role"] != "admin"){
    header("location: ../../index.php");
    exit();
}

// Gérer une classe de manière dynamique
$choixMenu = "adminContenu";
?>

<secction class="gestionAdmin mb-5 p-3">
    <div class="template p-2">
        <div class="menu mt-5">
            <a href="../../src/pages/admin.php?choix=listeCategorie">Gérer les catégories</a>
            <a href="../../src/pages/admin.php?choix=listeUser">Gérer les users</a>
            <a href="../../src/pages/admin.php?choix=listeCommentaire">Gérer les commentaires</a>
            <a href="../../src/pages/admin.php?choix=listeArticle">Gérer les articles</a>
        </div>
        <div class="<?= $choixMenu?>">
            <?php
                //Quand l'admin sélectionne les catégorie
                if(isset($_GET["choix"]) && $_GET["choix"] == "listeCategorie"){
                require "../../src/pages/adminInclude/categorie/listeCategorie.php";
            }
            ?>
        </div>
    </div>
</secction>


<?php
require "../../src/common/footer.php";
?>