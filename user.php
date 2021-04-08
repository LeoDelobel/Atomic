<link rel="stylesheet" href="css/style_index.css"/>
<link rel="stylesheet" href="css/style_user.css"/>






<?php
  session_start();
  require_once("php/class_user.php");
  require_once("php/class_video.php");
  require_once("header.php");

  $user = UserManager::FindUserByName(htmlspecialchars($_GET["u"]));
  ?>

<div class="test">
  <div class="field">
    <div class="user_pseudonyme"><?php echo $user->pseudonyme ?></div>
  </div>

  <div class="field">
    <div class="title_users">Statistique</div>
  </div>
</div>

  <?php
    // On affiche les infos confidentielles si il s'agit de l'user connecté
    if($_SESSION["auth"] && $_SESSION["id_utilisateur"] == $user->id_utilisateur){
   ?>
  <div class="user_meta">
    <div>Mail : <?php echo $user->mail ?></div>
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

  <h2>Dernières vidéos :</h2>

  <?php
    VideoManager::PrintVideos(VideoManager::GetByUser($user->id_utilisateur));
  ?>
