<?php
  function RemoveAbonnement($id_master, $id_slave){
    require("init_sql.php"); // On initialise la base de données
    $statement = $DATABASE->prepare("DELETE FROM abonner WHERE id_master = ? AND id_slave = ?"); // Commande SQL
    $statement->execute(array($id_master, $id_slave));

    return $statement; // On retourne vrai ou faux selon le succès de la commande
  }

  function GetAbonnes($id_utilisateur){
    require("init_sql.php");
    $statement = $DATABASE->prepare("SELECT COUNT(id_master) AS nombre FROM abonner WHERE id_master = ?");
    $statement->execute(array($id_utilisateur));
    $compte = $statement->fetchAll()[0];

    return $compte["nombre"];
  }

  function AddAbonnement($id_master,$id_slave)
  {
    require("init_sql.php");
    $statement = $DATABASE->prepare("INSERT INTO abonner (id_master, id_slave) VALUES (?, ?)");
    $statement->execute(array($id_master,$id_slave));
    $arr = $statement->errorInfo();
    print_r($arr);

    return $statement;
  }
 ?>
