<?php
# Script Name	: miniature.php
# Description	: Donne une div miniature à partir d'un id vidéo ($id)
# Author      : Léo Delobel
    function printMiniature($video){
      // LA FONCTION NE PREND QUE DES OBJETS VIDEO !
      require_once("class_user.php");
      require_once("class_video.php");

      // On retrouve l'auteur
      $auteur = UserManager::FindUser($video->$id_utilisateur);
      ?>

        <span class="miniature">
          <div class="miniature_meta">
            <a href="watch.php?id_video=<?php echo $video->id_video ?>">
            <img class="miniature_img" src="res/miniatures/<?php echo $video->id_video . '.' . $video->img_type ?>">
            <p class="miniature_titre"> <?php echo $video->titre ?></p>
            <p class="miniature_vues"> <?php
            $nb_vues = VueManager::GetVues($video->id_video);
            if($nb_vues == 1){
              echo $nb_vues . " vue";
            } else {
              echo $nb_vues . " vues";
            }
            ?></p>
            <p class="miniature_auteur"> <?php echo $auteur->pseudonyme ?></p>
            </a>
          </div>
        </span>

      <?php
    }
 ?>
