<?php
function GetLikes($id_video){
  require("init_sql.php");
  $statement = $DATABASE->prepare("SELECT COUNT(id_video) AS nombre FROM visionner WHERE id_video = ?");
  $statement->execute(array($id_video));
  $compte = $statement->fetchAll()[0];

  return $compte["nombre"];
}
 ?>
