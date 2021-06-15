<?php
    //Enregistrer un nouvel utilisateur dans notre base de données
    function createUser($avatar, $login, $nom, $prenom, $email, $mdp, $roleId, $ban){
        $bdd = dbAccess();
        $requete = $bdd->prepare("INSERT INTO users(avatar, login, nom, prenom, email, mdp, roleId, ban)
                                    VALUES(?,?,?,?,?,?,?,?)");
        $requete->execute(array($avatar, $login, $nom, $prenom, $email, $mdp, $roleId, $ban)) or die(print_r($requete->errorInfo(), TRUE));
        $requete->closeCursor();
    
    }

    // Fonction pour se connecter au site
function login($user, $password){
    // connection à la db
    $bdd = dbAccess();
    // requete pour récupérer l'user correspondant au login entré
    $requete = $bdd->query('SELECT * 
                            FROM users u 
                            INNER JOIN role r ON r.roleId = u.roleId;') or die(print_r($requete->errorInfo(), TRUE));

    // Traitement de la requete
    while($result = $requete->fetch()){
        if($result["login"] == $user){
            // sel du mdp envoyé avec le sel contenu dans la colonne ban
            $sel = md5($password) . $result["ban"];
            
            //J'active ma session user avec les infos dont je pourrai avoir besoin
            // tant que mon utilisateur est connecté 
            if($result["mdp"] == $sel){
                $_SESSION["connect"] = true;
                $_SESSION["user"] = [
                    "id" => $result["userId"],
                    "nom" => $result["nom"],
                    "prenom" => $result["prenom"],
                    "photo" => $result["avatar"],
                    "login" => $result["login"],
                    "email" => $result["email"],
                    "role" => $result["nomRole"]
                ];
                // J'active la session connecté
                $_SESSION["connecté"] = true;
                // Je redirige vers la page account
                header("location: ../../src/pages/account.php");
                exit();
            }
            else{
                
                header("location: ../../src/pages/login.php?erreur=Mot de passe incorrect");
                exit();
            }
        }
    }
    // Si mon script arrive ici, il est sorti de ma boucle sans trouver de user
    header("location: ../../src/pages/login.php?erreur=Identifiant inconnu, veuillez recommencer!");
    exit();
}

function updateImg($fichier){
    $bdd = dbAccess();
    // Préparer la requete pour updater données
    $requete = $bdd->prepare("UPDATE users 
                                SET avatar = ? 
                                WHERE userId = ?");
    $requete->execute(array($fichier, $_SESSION["user"]["id"]));
    $requete->closeCursor();
}

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