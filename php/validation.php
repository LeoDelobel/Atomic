<?php
  session_start();
  require_once("class_user.php");
  echo $_SESSION["id_utilisateur"];
  AbonnementManager::AddAbonnement(htmlspecialchars($_GET["id_master"]),$_SESSION["id_utilisateur"]);
  header('Location: ../index.php');
?>
