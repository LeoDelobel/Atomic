<?php
# Script Name	: search.php
# Description	: Affichage des vidéos recherchées
# Author      : Léo Delobel
# URL         : http://176.166.235.56/search.php
  include("header.php");
  include("php/init_sql.php");

  require_once("php/class_video.php");
  require_once("php/class_user.php");
  require_once("php/miniature.php");
 ?>
 <link rel="stylesheet" href="css/style_index.css"/>
 <link rel="stylesheet" href="css/style_search.css"/>
 <link rel="stylesheet" href="css/style_profil.css"/>
 <?php
  if(isset($_GET["q"])){

    $liste_videos = VideoManager::GetHaving($_GET["q"]);

    foreach($liste_videos as $video){
      ?>
      <div class="search_video">
        <?php
          printMiniature($video);
          UserManager::PrintProfil(UserManager::FindUser($video->id_utilisateur));
        ?>

      </div>
      <?php
    }
  }
  ?>
