<?php
  function GetCommentaires($id_video){
    // Retourne la liste des commentaires en objet SQL, ne print rien !

    require("init_sql.php");

    $statement = $DATABASE->prepare("SELECT * FROM commentaire WHERE id_video = ?");
    $statement->execute(array($id_video));
    $commentaires = $statement->fetchAll();

    // Liste des coms
    return $commentaires;
  }

  function PrintCommentaires($id_video){
    $liste_commentaires = GetCommentaires($id_video);

    foreach ($liste_commentaires as $commentaire){
      require_once("commentaire.php");
      PrintCommentaire($commentaire);
    }
  }
 ?>
