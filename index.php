<?php
# Script Name	: index.php
# Description	: Affichage de l'index (Vidéos du jour, Abonnements)
# Author      : Léo Delobel
# URL         : http://176.166.235.56
 ?>

<?php
  require_once("php/class_video.php");
 ?>

<html>
  <head>
    <link rel="stylesheet" href="css/style_index.css"/>

  </head>
  <body>
    <!-- On inclut le header -->
    <?php require 'header.php';?>
    <!-- -->
    <h2>- Vidéos récentes -</h2>
  <?php
    VideoManager::PrintVideos(VideoManager::GetRecentVideos());
  ?>
    <h2>- Vidéos populaires -</h2>
  <?php
    VideoManager::PrintVideos(VideoManager::GetMostPopularVideos());
  ?>

 </body>
</html>
