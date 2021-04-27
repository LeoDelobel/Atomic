<link rel="stylesheet" href="css/style_user.css"/>






<?php
  session_start();
  require_once("php/class_user.php");
  require_once("php/class_video.php");
  require_once("header.php");

  $user = UserManager::FindUserByName(htmlspecialchars($_GET["u"]));
  ?>


  <div class="field">
    <div class="user_pseudonyme"><?php echo $user->pseudonyme ?></div>
    <div class="orgapls">

      <div class="stat">
        <span><p><?php echo AbonnementManager::GetAbonnes($user->id_utilisateur)?> abonné·e·s </p></span>
        <span><p><?php echo AbonnementManager::GetAbonnements($user->id_utilisateur)?> abonnement·s</p></span>
        <span><p><?php echo VueManager::GetTotalVues($user->id_utilisateur)?> vues cumulé·s </p></span>
        <span><p><?php echo VideoManager::GetCountByUser($user->id_utilisateur)?> vidéo·s publié·e·s</p></span>
      </div>

      <?php
        // On affiche les infos confidentielles si il s'agit de l'user connecté
        if($_SESSION["auth"] && $_SESSION["id_utilisateur"] == $user->id_utilisateur){
      ?>
      <div class="user_meta">
        <div>Mes informations</div>

            <span><?php echo $user->mail ?><form action="" method="post"><input type="submit" name="change_mail" value="Modifier"></input></form></span>



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
</div>
<div class="last_upload">
  <div class="field1">Dernières vidéos :<div>
</div>




  <?php
    VideoManager::PrintVideos(VideoManager::GetByUser($user->id_utilisateur));
  ?>
