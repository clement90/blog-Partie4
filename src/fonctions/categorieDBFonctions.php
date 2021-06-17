<?php
//Fonction pour aller chercher la liste des catégorie 
function getHardCategorie(){
    $bdd = dbAccess();
    $requete = $bdd->query("SELECT *
                            FROM hardware") or die(print_r($requete->errorInfo(), TRUE));
    while($donnees = $requete->fetch()){
        $listeHardCategorie[] = $donnees;
    }
    $requete->closeCursor();
    return $listeHardCategorie;
}

//Ajouter une console
function addHardCategorie($console){
    $bdd = dbAccess();
    $requete = $bdd->prepare("INSERT INTO hardware(console) VALUES (?)");
    $requete->execute(array($console));
    $requete->closeCursor();
}

//Supprimer une console
function deleteHardCategorie($hardId){
    $bdd = dbAccess();
    $requete = $bdd->prepare("DELETE FROM hardware WHERE hardId = ?");
    $requete->execute(array($hardId)) or die(print_r($requete->errorInfo(), TRUE));
    $requete->closeCursor();
}

//Categorie type d'articles
//Chercher tout les types d'article
function getCategorie(){
    $bdd = dbAccess();
    $requete = $bdd->query("SELECT * FROM categorie");
    while($donnees = $requete->fetch()){
        $listeCategorie[] = $donnees;
    }
    $requete->closeCursor();
    return $listeCategorie;
}

//Ajouter un type d'article
function addTypeArticle($typeArticle){
    $bdd = dbAccess();
    $requete = $bdd->prepare("INSERT INTO categorie(nomCategorie) VALUES (?)") ;
    $requete->execute(array($typeArticle)) or die(print_r($requete->errorInfo(), TRUE));
    $requete->closeCursor();
}

//Supprimer un type d'article
function deleteTypeCategorie($intDeleteType){
    $bdd = dbAccess();
    $requete = $bdd->prepare("DELETE FROM categorie WHERE categorieId = ?");
    $requete->execute(array($intDeleteType)) or die(print_r($requete->errorInfo(), TRUE));
    $requete->closeCursor();
}

//Chercher toutes les catégorie de jeux
function getGameCat(){
    $bdd = dbAccess();
    $requete = $bdd->query("SELECT * FROM gamecategory") or die(print_r($requete->errorInfo(), TRUE));
    while($donnees = $requete->fetch()){
        $listeGameCat[] = $donnees;
    }
    $requete->closeCursor();
    return $listeGameCat;
}

//Ajouter une catégorie de jeux
function addGameCategorie($gameCat){
    $bdd = dbAccess();
    $requete = $bdd->prepare("INSERT INTO gamecategory(genre) VALUES (?)") ;
    $requete->execute(array($gameCat)) or die(print_r($requete->errorInfo(), TRUE));
    $requete->closeCursor();
}

function deleteGameCategorie($id){
    $bdd = dbAccess();
    $requete = $bdd->prepare("DELETE FROM gamecategory WHERE gameCategoryId = ?");
    $requete->execute(array($id)) or die(print_r($requete->errorInfo(), TRUE));
    $requete->closeCursor();
}
?>