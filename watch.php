<?php
# Script Name	: watch.php
# Description	: Affichage d'une vidéo et de ses informations
# Author      : Léo Delobel
# URL         : http://176.166.235.56/watch.php
  include("header.php");
  include("php/init_sql.php");
  include_once("php/like.php");
  require_once("php/class_commentaire.php");
  require_once("php/class_user.php");
  require_once("php/class_video.php");

 ?>
<link rel="stylesheet" href="css/style_search.css"/>
<link rel="stylesheet" href="css/style_commentaire.css"/>
<link rel="stylesheet" href="css/style_profil.css"/>

 <div class="video-container">
   <div class="video">
     <?php
      $video = VideoManager::GetById($_GET["id_video"]);
      $auteur = UserManager::FindUser($video->id_utilisateur);

      # La vidéo se trouve dans res/videos/[ID_VIDEO].mp4
      ?>

      <?php
      if(isset($_POST["like"]))
      {
        AddLike($_SESSION["id_utilisateur"],$video->id_video);
        header('Location: ./watch.php?id_video=' . $_GET["id_video"]);
      }
      if(isset($_POST["unlike"]))
      {
        RemoveLike($_SESSION["id_utilisateur"],$video->id_video);
        header('Location: ./watch.php?id_video=' . $_GET["id_video"]);
      }
      if(isset($_POST["commenter"]))
      {
        CommentaireManager::AddCommentaire($video->id_video, $_SESSION["id_utilisateur"], $_POST["message"]);
        header('Location: ./watch.php?id_video=' . $_GET["id_video"]);
      }
      if(isset($_POST["delete_com"]))
      {
        CommentaireManager::RemoveCommentaire($_POST["id_commentaire"]);
        header('Location: ./watch.php?id_video=' . $_GET["id_video"]);
      }

      ?>

      <video controls>
        <source src="res/videos/<?php echo $video->id_video?>.mp4" type="video/mp4">
      </video>
   </div>

   <div class="video-meta">
     <p>
       <?php
       require("php/vues.php");
       require_once("php/like.php");
       echo GetVues($video->id_video) . ' vues  •  ';
       echo $video->date_publication . '  •  👍';
       echo GetLikes($video->id_video);
       if($_SESSION["auth"]){
         // Si l'utilisateur est connecté, il a un id utilisateur à ajouter
         if(AddVue($video->id_video, $_SESSION["id_utilisateur"])){
         }
       } else {
         // Sinon utiliser l'user Anonymous (id : 0)
         if(AddVue($video->id_video, 0)){
         }
       }
       ?></p>


     <br><hr><br><h2 style="text-indent: 25px">
      <?php echo $video->titre; ?></h2>
      <br>
     <hr>
     <br>
     <p><?php
       UserManager::PrintProfil($auteur);
     ?></p>
     <hr>
     <?php if($_SESSION["auth"]){?>
     <form action="" method="post" class="formCommentaire">
       <textarea cols="86" rows="2" name="message" class="commentaire_message"></textarea>
       <input type="submit" value="Commenter" name="commenter" style="color: black">
     </form>
     <hr>
     <h4>Description</h4>
   <?php }

   if($_SESSION["auth"])
     {
       #Si connecté
            if(CheckLike($_SESSION["id_utilisateur"], $video->id_video))
            {
              #Si déjà liké
              ?>
              <form method="post" action="" >
                <input type="submit" name="unlike" value="J\'aime pas" style="color: black">
              </form>
              <?php
            }
            else
            {
              #Pas liké
              ?>
              <form method="post" action="" >
                <input type="submit" name="like" value="J\'aime" style="color: black">
              </form>
              <?php
            }
     }
     ?>
     <p><?php echo $video->description;?></p>
   </div>

   <div class="commentaires">
     <?php
        CommentaireManager::PrintCommentaires($video->id_video);
      ?>
   </div>

 </div>
