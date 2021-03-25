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
    // Vérifie la dernière vue pour éviter le spam (Limite de 1 vue par 30 secondes);

    require("init_sql.php");
    // On récupère la dernière vue de l'utilisateur
    $statement = $DATABASE->prepare("SELECT date_visionnage FROM visionner WHERE id_video = ? AND id_utilisateur = ? ORDER BY date_visionnage DESC LIMIT 1");
    $statement->execute(array($id_video, $id_utilisateur));
    $last_vue = $statement->fetchAll()[0]["date_visionnage"];

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
