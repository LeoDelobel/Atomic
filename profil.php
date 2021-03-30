<?php
  session_start();
  require_once("php/class_user.php");

  $profil_user = UserManager::FindUser($_SESSION["id_utilisateur"]);
  print_r($profil_user);

 ?>
