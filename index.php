<?php
# Script Name	: index.php
# Description	: Affichage de l'index (Vidéos du jour, Abonnements)
# Author      : Léo Delobel
# URL         : http://176.166.235.56
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
    require 'php/liste_videos.php';
    GetRecentVideos();
  ?>
    <h2>- Pour vous -</h2>
  <?php
    GetMostPopularVideos();
  ?>

 </body>
</html>
