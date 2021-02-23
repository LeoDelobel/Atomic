<?php
  function GetVues($id_video){
    require("init_sql.php");
    $statement = $DATABASE->prepare("SELECT COUNT(id_video) AS nombre FROM visionner WHERE id_video = ?");
    $statement->execute(array($id_video));
    $compte = $statement->fetchAll()[0];

    return $compte["nombre"];
  }

  function AddVue($id_video, $id_utilisateur){
    require("init_sql.php");
    $statement = $DATABASE->prepare("INSERT INTO visionner(id_utilisateur, id_video, date_visionnage) VALUES (?, ?, NOW())");
    $statement->execute(array($id_utilisateur, $id_video));

    return true;
  }
 ?>
