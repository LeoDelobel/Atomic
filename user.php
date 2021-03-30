<link rel="stylesheet" href="css/style_index.css"/>

<?php
  session_start();
  require_once("php/class_user.php");
  require_once("php/class_video.php");
  require_once("header.php");

  $user = UserManager::FindUserByName(htmlspecialchars($_GET["u"]));
  ?>

  <div class="user_banniere">
    <h1 class="user_pseudonyme"><?php echo $user->pseudonyme ?></h1>
  </div>

  <?php
    // On affiche les infos confidentielles si il s'agit de l'user connecté
    if($_SESSION["auth"] && $_SESSION["id_utilisateur"] == $user->id_utilisateur){
   ?>

   <hr>
   <h2>Informations personnelles : </h2>

  <div class="user_meta">
    <h3>Mail : <?php echo $user->mail ?></h3>
    <form action="" method="post">
      <input type="submit" name="change_pass" value="Changer de mot de passe"></input>
    </form>
    <form action="" method="post">
      <input type="submit" name="change_mail" value="Changer d'adresse mail"></input>
    </form>
  </div>

  <?php
    }
  ?>

  <hr>
  <h2>Dernières vidéos :</h2>

  <?php
    VideoManager::PrintVideos(VideoManager::GetByUser($user->id_utilisateur));
  ?>
