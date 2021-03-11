<?php
# Script Name	: ajout_video.php
# Description	: Page d'ajout de video
# Author      : Léo Delobel
# URL         : http://176.166.235.56/ajout_video.php
 ?>

 <?php
// On affiche le header
require 'header.php';
require_once("php/class_categorie.php");
require_once("php/class_video.php");

if(isset($_POST["ajout"])){
  // Demande d'ajout de vidéo
  $dir_miniatures = "/var/www/atomic/res/miniatures/";

  if(
    $_SESSION["auth"] && // Si l'utilisateur est connecté
    is_numeric($_POST["categorie"]) && // Si l'id catégorie est un nombre
    in_array($_POST["categorie"], CategorieManager::GetIDs()) // Et fait partie des id existants
  ){
    // AddVideo($id_utilisateur, $id_categorie, $titre, $description)
    $SQL = VideoManager::AddVideo(
      $_SESSION["id_utilisateur"],
      $_POST["categorie"],
      $_POST["titre"],
      $_POST["description"]);
    if($SQL["success"]){
        // Si l'ajout SQL s'est bien passé
        if($_FILES['miniature']['size'] <= 2097152){
          // Si le fichier fait moins de 2Mo
          $path_miniature = $dir_miniatures . $SQL["id_video"] . '.' . substr($_FILES['miniature']['type'], 6);
          if (move_uploaded_file($_FILES['miniature']['tmp_name'], $path_miniature)) {
            echo "La miniature a été téléchargée avec succès\n";
          } else {
            echo "Erreur de téléchargement :\n";
            print_r($_FILES);
          }
        }
      }
  }
}

 // Si l'utilisateur est connecté
 if($_SESSION["auth"]){
  ?>

<form enctype="multipart/form-data" action="" method="post">
  <p>Titre :</p>
  <input type="text" name="titre">

  <p>Description :</p>
  <textarea type="text" name="description"></textarea>

  <p>Catégorie :</p>
  <select name="categorie">
    <?php
      foreach(CategorieManager::GetAll() as $c){
        echo '<option value="' . $c->id_categorie . '">' . $c->description . '</option>';
      }
     ?>
  </select>

  <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
  <p>Miniature :</p>
  <input name="miniature" type="file" />

  <input type="submit" name="ajout" value="Upload"/>
</form>

  <?php
} else {
  // Sinon
 ?>

<p>Vous n'êtes pas connecté !</p>

 <?php
}
  ?>
