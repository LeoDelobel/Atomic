<?php
  function GetVues($id_video){
    // Récupère le nombre de vues d'une vidéo donnée

    require("init_sql.php");
    $statement = $DATABASE->prepare("SELECT COUNT(id_video) AS nombre FROM visionner WHERE id_video = ?");
    $statement->execute(array($id_video));
    $compte = $statement->fetchAll()[0];

    return $compte["nombre"];
  }

  function AddVue($id_video, $id_utilisateur){
    // Ajoute une vue à une vidéo donnée

    require("init_sql.php");
    $statement = $DATABASE->prepare("INSERT INTO visionner(id_utilisateur, id_video) VALUES (?, ?)");
    $statement->execute(array($id_utilisateur, $id_video));

    if(!$statement){
      // Si la commande SQL a reçu une erreur
      return false;
    } else {
      // Sinon tout va bien
      return true;
    }
  }
 ?>
