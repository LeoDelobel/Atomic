<?php
    function GetOtherVideos(){
      require 'php/init_sql.php';
      $statement = $DATABASE->prepare("SELECT id_video FROM video");
      $statement->execute();
      #Hello
      $liste_id = $statement->fetchAll();

        # On commence la liste des vidéos
      echo '<div class="liste_videos">';
      echo '<ul>';
      foreach($liste_id as $id){
        echo '<li style="display:inline-block">';
          require_once('miniature.php');
          printMiniature($id['id_video']);
        echo "</li>";
      }
      echo "</ul>";
        # La liste est finie

      echo '</div>';
    }

    function GetDailyVideos(){
      require 'php/init_sql.php';
      $statement = $DATABASE->prepare("SELECT id_video FROM video WHERE date(date_publication) = CURDATE()");
      $statement->execute();
      #Hello
      $liste_id = $statement->fetchAll();

        # On commence la liste des vidéos
      echo '<div class="liste_videos">';
      echo '<ul>';
      foreach($liste_id as $id){
        echo '<li style="display:inline-block">';
          require_once('miniature.php');
          printMiniature($id['id_video']);
        echo "</li>";
      }
      echo "</ul>";
        # La liste est finie

      echo '</div>';
    }
 ?>
