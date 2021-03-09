<?php
  session_start();
  require_once("abonnes.php");
  echo $_SESSION["id_utilisateur"];
  AddAbonnement(htmlspecialchars($_GET["id_master"]),$_SESSION["id_utilisateur"]);
  header('Location: ../index.php');
?>
