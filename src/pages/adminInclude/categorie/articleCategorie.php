<?php
    //Mon formulaire ajout type a-t-il été envoyé?
    //Vérifier si admin
    if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
        //Gérer les ajouts type categorie
        if(isset($_POST["type"]) && !empty($_POST["type"])){

            $typeArticle = htmlspecialchars($_POST["type"]);
            addTypeArticle($typeArticle);
        }

        //Effacer une console
        if(isset($_GET["deleteType"]) && $_GET["deleteType"] == true){
            $deleteType = htmlspecialchars($_GET["value"]);
            $intDeleteType = intval($deleteType);
            deleteTypeCategorie($intDeleteType);
        }
    }

    //Je récupère les types d'articles dispo dans ma DB 
    $listeTypeCategorie = getCategorie();

?>

<table class="mlr-a mt-3 p-1" id="typeArticle">

    <thead>
        <tr>
            <th colspan="2">Liste des articles</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Nom de la catégorie</td>
            <td>Supprimer</td>
        </tr>

        <!-- Foreach pour afficher les types d'articles disponible -->

        <?php
            foreach($listeTypeCategorie as $value){
            ?>
            <tr>
                <td><?= $value["nomCategorie"]?></td>
                <td class="ta-c tc-r"><a href="../../src/pages/admin.php?choix=listeCategorie&deleteType=true&value=<?= $value["categorieId"]?>"><i class="far fa-plus-square"></i></a></td>
            </tr>
            <?php
            }
        ?>
            <tr>
                <td>Ajouter un type</td>
                <td class="ta-c tc-g"><a href="../../src/pages/admin.php?choix=listeCategorie&createType=true/#typeArticle"><i class="far fa-plus-square"></i></a></td>
            </tr>
        <?php
            if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
                if(isset($_GET["createType"]) && $_GET["createType"] == true){
                    ?>
                        <form action="" method="post">  
                            <tr>
                                <td>Type d'article à ajouter</td>
                                <td class="ta-c tc-g"><input type="text" name="type" placeholder="Entrez le type d'article" required></td>
                                <td><input type="submit" value="Ajouter type"></td>
                            </tr>
                        </form>

                    <?php
                }
            }
        ?>

    </tbody>

</table>