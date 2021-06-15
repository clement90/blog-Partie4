<?php
    //J conditionne l'accès à ces focntions aux seuls admins
    if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
        //Gérer les ajouts de nouveau matériel
        if(isset($_POST["hardware"]) && !empty($_POST["hardware"])){

            $console = htmlspecialchars($_POST["hardware"]);
            addHardCategorie($console);
        }

        //Effacer une console
        if(isset($_GET["delete"]) && $_GET["delete"] == true){
            $hardId = htmlspecialchars($_GET["value"]);
            $intHardId = intval(($hardId));
            deleteHardCategorie($intHardId);
        }
    }

    // Je récupère la liste catégorie
    $listeCategorie = getHardCategorie();
  
    //Conditionner l'accès au requete ci-dessous uniquement si le user est admin
    /* if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] = "admin")
    {


    } */
?>

<table class="mlr-a mt-3 p-1">
    <thead>
        <tr>
            <th colspan="2">Liste des Hardwares</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Nom de la catégorie</td>
            <td>Supprimer</td>
        </tr>
        <?php
            foreach($listeCategorie as $value){
                ?>
                    <tr>
                        <td><?= $value["console"]?></td>
                        <td class="ta-c tc-r"><a href="../../src/pages/admin.php?choix=listeCategorie&delete=true&value=<?=$value["hardId"]?>"><i class="far fa-plus-square"></a></td>
                    </tr>
                <?php
            }
        ?>
        <tr>
            <td>Ajouter un hardware</td>
            <td class="ta-c tc-g"><a href="../../src/pages/admin.php?choix=listeCategorie&create=true"><i class="far fa-plus-square"></i></a></td>
        </tr>

        <?php
        // Je conditionne l'accès aux fonction ci-dessous aux seuls administrateurs du site
            if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
                // Formulaire pour ajouter harware
                if(isset($_GET["create"]) && $_GET["create"]==true){
                    ?>
                        <form action="../../src/pages/admin.php?choix=listeCategorie" method="post">  
                            <tr>
                                <td>Nom du hardware à ajouter</td>
                                <td class="ta-c tc-g"><input type="text" name="hardware" placeholder="Entrez le nom du hard" required></td>
                                <td><input type="submit" value="Ajouter hardware"></td>
                            </tr>
                        </form>

                    <?php
                }
            }
        ?>
    </tbody>

</table>