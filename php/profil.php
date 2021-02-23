<?php
  function PrintProfil($id_utilisateur){
    include("init_sql.php");
    $statement = $DATABASE->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ?");
    $statement->execute(array($id_utilisateur));

    $utilisateur = $statement->fetchAll()[0];
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
