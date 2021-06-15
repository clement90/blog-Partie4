<?php
    //Je crée ma fonction grain de sel qui va générer un chaine aléatoire que l'on rajoutera
    //au hash du mot de passe pour complexifier se decryption  par un eventul hacker

    function grainDeSel($x)
    {
        //je crée un variable qui contiendra les charactères qui peuvent  composer un hash md5
        $chars = "0123456789abcdef";
        $string = "";
        // je crée un boucle qui va choisir une série de x charachtères
        // le x étant le paramètre de ma focntion, il serat lui aussi généré aléatoirement
        for($i=0; $i<$x; $i++)
        {
            $string .= $chars[rand(0, strlen($chars)-1)];
        }
        return $string;
    }

    //function pour envoyer une image qui prendra en compte l'endroit ou sera envoyé l'upload selon
    //que ce soit un avatar ou pour un article

    function sendImg($photo, $desination)
    {
        //Décider ou dois aller ma photo
        if($desination == "avatar")
        {
            $dossier = "../../src/img/avatar/" . time();
        }
        else
        {
            $dossier = "../../src/img/article/". time();
        }

        // Créer un tableau avec les extensions autorisée
        $extensionArray = ["png", "jpg", "jpeg", "jfif", "PNG", "JPG", "JPEG", "JFIF"];
        // Récupérer toutes les infos du fichier envoyé
        $infoFichier = pathinfo($photo["name"]);
        //je récupère l'extension du fichier envoyé
        $extensionImage = $infoFichier["extension"];

        // Extension autorisée ?
        if(in_array($extensionImage, $extensionArray)){
            //préparer le chemin répértoire + fichier
            $dossier .= basename($photo["name"]);
            // envoyer mon fichier 
            move_uploaded_file($photo["tmp_name"], $dossier);
        }
        return $dossier;
    }

    //focntion pour savoir si un user est connecté ou non
    function estConnecte(){
        if(isset($_SESSION["connecté"]) && $_SESSION["connecté"]== TRUE){
            header("location: ../../index.php");
        }
    }
?>