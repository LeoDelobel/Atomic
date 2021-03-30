<?php
  session_start();
  require_once("class_user.php");
  AbonnementManager::RemoveAbonnement(htmlspecialchars($_GET["id_master"]),$_SESSION["id_utilisateur"]);
?>
