<?php
  function PrintProfil($id_utilisateur){
    include("init_sql.php");
    include("class_user.php");

    $utilisateur = UserManager::FindUser($id_utilisateur);
    ?>

    <span class="profil">
      <img class="profil_img" src="res/miniatures/<?php echo $video["id_video"] ?>.jpg">
      <div class="profil_meta">
        <p class="profil_nom"> <?php echo $utilisateur["pseudonyme"] ?></p>
        <p class="profil_abonnes"> <?php echo 0 ?> abonnés</p>
        <button class="abonnement"> S'abonner </p>
      </div>
    </span>

    <?php
  }
?>
