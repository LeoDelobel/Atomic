<link rel="stylesheet" href="css/style_index.css"/>

<?php
  session_start();
  require_once("php/class_user.php");
  require_once("php/class_video.php");
  require_once("header.php");

  $profil_user = UserManager::FindUser($_SESSION["id_utilisateur"]);
  print_r($profil_user);

  VideoManager::PrintVideos(VideoManager::GetByUser($_SESSION["id_utilisateur"]));
 ?>
