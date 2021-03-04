<?php
  function PrintCommentaire($commentaire){
    // Print un commentaire selon un objet SQL (Voir liste_commentaires.php)

    require_once("class_user.php");

    // On génère un objet user depuis son id et on prend son pseudonyme
    echo 'De : ' . UserManager::FindUser($commentaire["id_utilisateur"])->pseudonyme;
    echo 'Le : ' . $commentaire["date_publication"];
    // On print le contenu
    echo $commentaire["message"];
  }
 ?>
