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
    <div class="user_pseudonyme"><?php echo $user->pseudonyme ?>


        <?php
          // On affiche les infos confidentielles si il s'agit de l'user connecté
          if($_SESSION["auth"] && $_SESSION["id_utilisateur"] == $user->id_utilisateur){
         ?>
        <div class="user_meta">
          <div>Mes informations</div>
          <div class="conteneur">
            <div><?php echo $user->mail ?></div>
          <form action="" method="post">
            <input type="submit" name="change_mail" value="Modifier"></input>
          </form>
        </div>


        <div class="conteneur">
          <form action="" method="post">
            <input type="submit" name="change_pass" value="Modifier"></input>
          </form>
        </div>

          <form class="helo" action="php/disconnect.php" method="POST"><button class="button">Changer de compte</button></form>
        </div>
        <?php
          }
        ?>

    </div>
  </div>

  <div class="field">
    <div class="title_users">Statistique</div>
  </div>
</div>
<div class="last_upload">
  <div class="field1">Dernières vidéos :<div>
</div>




  <?php
    VideoManager::PrintVideos(VideoManager::GetByUser($user->id_utilisateur));
  ?>
