<?php
# Script Name	: index.php
# Description	: Affichage de l'index (Vidéos du jour, Abonnements)
# Author      : Léo Delobel
# URL         : http://176.166.235.56
 ?>

<?php
  require_once("php/class_user.php");
  require_once("php/class_video.php");
  session_start();
 ?>

<html>
  <head>
    <link rel="stylesheet" href="css/style_index.css"/>

  </head>
  <body>
    <!-- On inclut le header -->
    <?php require 'header.php';?>
    <!-- -->
    <h1>Vidéos récentes de vos abonnements</h1>
    <?php
      $liste_abonnements = AbonnementManager::GetIdAbonnements($_SESSION["id_utilisateur"]);
      foreach($liste_abonnements as $id){
        if($id != $_SESSION["id_utilisateur"]){
          // On ne s'inclut pas soi même
     ?>
    <h2>De <?php echo UserManager::FindUser($id)->pseudonyme?> :</h2>
  <?php
        VideoManager::PrintVideos(VideoManager::GetByUser($id));
      }
    }
  ?>

 </body>
</html>
