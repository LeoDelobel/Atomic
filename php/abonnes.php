<?php
  

  function GetAbonnes($id_utilisateur){
    require("init_sql.php");
    $statement = $DATABASE->prepare("SELECT COUNT(id_master) AS nombre FROM abonner WHERE id_master = ?");
    $statement->execute(array($id_utilisateur));
    $compte = $statement->fetchAll()[0];

    return $compte["nombre"];
  }
 ?>
