<?php
//Afficher la liste des jeux
function getListGame(){
    $bdd = dbAccess();
    $requete = $bdd->query("SELECT *
                            FROM jeux j
                            INNER JOIN hardware h ON h.hardID = j.consoleId
                            INNER JOIN gamecategory g ON g.gameCategoryId = j.gamecategoryID") or die(print_r($bdd->errorInfo(), TRUE));
    while($donnees = $requete->fetch()){
        $listeJeux[] = $donnees;
    }
    $requete->closeCursor();
    return $listeJeux;
}
//Obtenir la liste des consoles
function getHard(){
    $bdd = dbAccess();
    $requete = $bdd->query("SELECT * FROM hardware") or die(print_r($bdd->errorInfo(), TRUE));
    while($donnees = $requete->fetch()){
        $listeConsole[] = $donnees;
    }
    $requete->closeCursor();
    return $listeConsole;
}
//Obtenir la liste des genres
function getGenre(){
    $bdd = dbAccess();
    $requete = $bdd->query("SELECT * FROM gamecategory") or die(print_r($bdd->errorInfo(), TRUE));
    while($donnees = $requete->fetch()){
        $listeGenre[] = $donnees;
    }
    $requete->closeCursor();
    return $listeGenre;
}
//Ajouter un jeu
function addGame($nom, $developpeur, $editeur, $dateDeSortie, $cover, $console, $genre){
    $bdd = dbAccess();
    $requete = $bdd->prepare("INSERT INTO jeux(nom, developpeur, editeur, dateDeSortie, cover, consoleId, gameCategoryId)
                                VALUES (?,?,?,?,?,?,?)");
    $requete->execute(array($nom, $developpeur, $editeur, $dateDeSortie, $cover, $console, $genre)) or die(print_r($bdd->errorInfo(), TRUE));
    $requete->closeCursor();
}
//Supprimer un jeu
function deleteGame($gameId){
    $bdd = dbAccess();
    $requete = $bdd->prepare("DELETE FROM jeux WHERE gameId = ?");
    $requete->execute(array($gameId)) or die(print_r($requete->errorInfo(), TRUE));
    $requete->closeCursor();
}
//Vérification si le jeu existe dans la base de données
function verifGame($nom, $console){
    $bdd = dbAccess();
    $requete = $bdd->prepare("SELECT * FROM jeux WHERE nom = ? AND consoleId = ?");
    $requete->execute(array($nom, $console)) or die(print_r($bdd->errorInfo(), TRUE));
    while($donnees = $requete->fetch()){
        $jeux[] = $donnees;
    }
    if(isset($jeux)&& !empty($jeux)){
        return false;
    }else{
        return true;
    }
}
?>
