<?php
# Script Name	: search.php
# Description	: Affichage des vidéos recherchées
# Author      : Léo Delobel
# URL         : http://176.166.235.56/search.php
  include("header.php");
  include("php/init_sql.php");
 ?>
 <link rel="stylesheet" href="css/style_index.css"/>
<link rel="stylesheet" href="css/style_search.css"/>
 <?php
  if(isset($_GET["q"])){
    $statement = $DATABASE->prepare(
"SELECT video.id_video, video.id_utilisateur, count(visionner.id_video) as vues FROM video INNER JOIN visionner ON video.id_video = visionner.id_video WHERE video.titre LIKE '%e%' GROUP BY video.id_video ORDER BY vues DESC");
    $statement->execute(array('%' . $_GET["q"] . '%'));

    $liste_videos = $statement->fetchAll();
    include("php/miniature.php");
    include("php/profil.php");

    foreach($liste_videos as $video){
      ?>
      <div class="search_video">
        <?php
          printMiniature($video['id_video']);
          printProfil($video['id_utilisateur']);
        ?>

      </div>
      <?php
    }
  }
  ?>
