<?php
        require "../../src/fonctions/gameDBFonctions.php";
        $listeJeux = getListGame();
        $listeConsole = getHard();
        $listeGenre = getGenre();

        //Vérification des input
        if(isset($_POST["nom"])&& !empty($_POST["nom"]) && !empty($_POST["developpeur"]) && !empty($_POST["editeur"]) && !empty($_POST["dateDeSortie"])
        && !empty(["cover"]) && !empty($_POST["console"]) && !empty(["genre"])){
            $option = array(
                "nom" => FILTER_SANITIZE_STRING,
                "developpeur" => FILTER_SANITIZE_STRING,
                "editeur" => FILTER_SANITIZE_STRING,
                "dateDeSortie" => FILTER_SANITIZE_STRING,
                "cover" => FILTER_SANITIZE_STRING,
                "console" => FILTER_SANITIZE_NUMBER_INT,
                "genre" => FILTER_SANITIZE_NUMBER_INT
            );

            $result = filter_input_array(INPUT_POST, $option);
            
            //Remplire les variable
            $nom = $_POST["nom"];
            $developpeur = $_POST["developpeur"];
            $editeur = $_POST["editeur"];
            $dateDeSortie = $_POST["dateDeSortie"] . " 00:00:00";
            $cover = $_POST["cover"];
            $console = $_POST["console"];
            $genre = $_POST["genre"];

            //Vérifier que le jeu n'existe pas déjà dans la base de données

            $verifGame = verifGame($nom, $console);
            if(isset($verifGame) && $verifGame == TRUE){
            //Faire appel a la fonction addGame()
            addGame($nom, $developpeur, $editeur, $dateDeSortie, $cover, $console, $genre);
            header("location: ../../src/pages/admin.php?choix=listeJeu");
            exit();
            }else{
                echo "Ce jeux existe déjà!";
            }
        }

        if(isset($_GET["deleteJeu"]) && $_GET["deleteJeu"] == TRUE)
        {
            $deleteJeu = htmlspecialchars($_GET["value"]);
            $intDeleteJeu = intval($deleteJeu);
            deleteGame($intDeleteJeu);
            header("location: ../../src/pages/admin.php?choix=listeJeu");
            exit();
        }
        
         
    ?>


<h2 class="ta-c mt-5">Liste des jeux</h2>
<div class="gestionCategorie">

    
    <h3>
    <a href="../../src/pages/admin.php?choix=listeJeu&createJeu=true"><i class="far fa-plus-square"></i>Ajouter Jeux</a>
    </h3>
</div>


<?php
    //Afficher le formulaire d'encodage d'un jeu
    if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
        if(isset($_GET["createJeu"]) && $_GET["createJeu"] == true){
            ?>
            <table class="mlr-a mt-3 p-1">
                <form action="" method="POST">
                <tr>
                    <td><input type="text" name="nom" placeholder="Nom du jeux" required></td>
                </tr>
                <tr>
                    <td><input type="text" name="developpeur" placeholder="Développeur" required></td>
                </tr>
                <tr>
                    <td><input type="text" name="editeur" placeholder="Editeur"></td>
                </tr>
                <tr>
                    <td><input type="date" name="dateDeSortie" required></td>
                </tr>
                <tr>
                    <td><input type="text" name="cover" placeholder="Adresse cover" required></td>
                </tr>
                <tr>
                    <td><select name="console">
                    <?php
                    foreach($listeConsole as $value){
                        echo '<option value="' . $value["hardId"] .'">' . $value["console"] . '</option>';
                    }
                    ?>
                    </select></td>
                </tr>
                <tr>
                    <td><select name="genre">
                    <?php
                    foreach($listeGenre as $value){
                        echo '<option value="' . $value["gameCategoryId"] .'">' . $value["genre"] . '</option>';
                    }
                    ?>
                    </select></td>
                </tr>
                <tr>
                    <td><input type="submit" value="Enregistrer le jeu"></td>
                </tr>
                </form>
            </table>
            <?php
        }
    }
?>

<table class="mlr-a mt-3 p-1" id="listeJeux">

    <thead>
        <tr>
            <th colspan="8">Liste des Jeux</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Nom du jeux</td>
            <td>Développeur</td>
            <td>Editeur</td>
            <td>Date de sortie</td>
            <td>Cover</td>
            <td>Console</td>
            <td>Genre</td>
            <td>Supprimer</td>
        </tr>

        <!-- Foreach pour afficher les jeux disponible -->

        <?php
            foreach($listeJeux as $value){
            ?>
            <tr>
                <td><?= $value["nom"]?></td>
                <td><?= $value["developpeur"]?></td>
                <td><?= $value["editeur"]?></td>
                <td><?php $dateDeSortie = explode(" ", $value["dateDeSortie"]);echo $dateDeSortie[0];?></td>
                <td><?= $value["cover"]?></td>
                <td><?= $value["console"]?></td>
                <td><?= $value["genre"]?></td>
                <td class="ta-c tc-r"><a href="../../src/pages/admin.php?choix=listeJeu&deleteJeu=true&value=<?= $value["gameId"]?>"><i class="far fa-plus-square"></i></a></td>
            </tr>
            <?php
            }
        ?>
    </tbody>

</table>