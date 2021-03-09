<?php
# Script Name	: watch.php
# Description	: Affichage d'une vidéo et de ses informations
# Author      : Léo Delobel
# URL         : http://176.166.235.56/watch.php
  include("header.php");
  include("php/init_sql.php");
  include_once("php/like.php");
  require("php/commentaire.php");
 ?>
<link rel="stylesheet" href="css/style_search.css"/>
 <div class="video-container">
   <div class="video">
     <?php
      $statement = $DATABASE->prepare("SELECT * FROM video WHERE id_video = ?");
      $statement->execute(array($_GET["id_video"]));

      $video = $statement->fetchAll()[0];
      # La vidéo se trouve dans res/videos/[ID_VIDEO].mp4

      $statement = $DATABASE->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ?");
      $statement->execute(array($video["id_utilisateur"]));

      $auteur = $statement->fetchAll()[0];
      ?>

      <?php
      if(isset($_POST["like"]))
        {
          AddLike($_SESSION["id_utilisateur"],$video["id_video"]);
        }
      if(isset($_POST["unlike"]))
      {
        RemoveLike($_SESSION["id_utilisateur"],$video["id_video"]);
      }
      if(isset($_POST["commenter"]))
      {
        AddCommentaire($video["id_video"], $_POST["message"]);
      }

      ?>

      <video controls>
        <source src="res/videos/<?php echo $video["id_video"];?>.mp4" type="video/mp4">
      </video>
   </div>

   <div class="video-meta">
     <p>
       <?php
       require("php/vues.php");
       require_once("php/like.php");
       echo GetVues($video["id_video"]) . ' vues  •  ';
       echo $video["date_publication"] . '  •  👍';
       echo GetLikes($video["id_video"]);
       if($_SESSION["auth"]){
         // Si l'utilisateur est connecté, il a un id utilisateur à ajouter
         if(AddVue($video["id_video"], $_SESSION["id_utilisateur"])){
         }
       } else {
         // Sinon utiliser l'user Anonymous (id : 0)
         if(AddVue($video["id_video"], 0)){
         }
       }
       ?></p>

     <hr>
     <p><?php require_once("php/profil.php");
       PrintProfil(2);
     ?></p>
     <hr>
     <?php if($_SESSION["auth"]){?>
     <form action="" method="post" class="formCommentaire">
       <textarea cols="86" rows="2" name="message"></textarea>
       <input type="submit" value="Commenter" name="commenter">
     </form>
     <hr>
     <h4>Description</h4>
   <?php }

   if($_SESSION["auth"])
     {
       #Si connecté
            if(CheckLike($_SESSION["id_utilisateur"], $video["id_video"]))
            {
              #Si déjà liké
              echo'<form method="post" action="" >
                     <input type="submit" name="unlike" value="J\'aime pas">
                   </form>';

            }
            else
            {
              #Pas liké
              echo'<form method="post" action="" >
                     <input type="submit" name="like" value="J\'aime">
                   </form>';
            }
     }
     ?>
     <p><?php echo $video["description"];?></p>
   </div>

   <div class="commentaires">
     <?php
        require_once("php/liste_commentaires.php");
        PrintCommentaires($video["id_video"]);
      ?>
   </div>

 </div>
