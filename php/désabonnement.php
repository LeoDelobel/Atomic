<?php
  session_start();
  require_once("abonnes.php");
  RemoveAbonnement(htmlspecialchars($_GET["id_master"]),$_SESSION["id_utilisateur"]);
?>
