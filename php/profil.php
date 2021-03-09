<html>
  <head><link rel="stylesheet" href="css/style_profil.css"></head>
  <body>
    <?php
      function PrintProfil($id_utilisateur){
        include("init_sql.php");
        require_once("class_user.php");

        $utilisateur = UserManager::FindUser($id_utilisateur);
        require_once("abonnes.php");
        ?>

        <div class="profil">
          <div class="orga">
          <img class="profil_img" src="res/profil/<?php echo $utilisateur->id_utilisateur?>.jpg">
          <div class="info">
            <p class="profil_pseudo"> <?php echo $utilisateur->pseudonyme ?></p>
            <p class="profil_abonnes"> <?php echo GetAbonnes($id_utilisateur) ?> abonnés</p>
          </div>
        </div>
          <a href="php/validation.php?id_master=<?php echo $utilisateur->id_utilisateur?>">
            <input class="abonnement_button" type="submit" name="abonnement" value="S'abonner">
          </a>
        </div>

        <?php
      }
    ?>
  </body>
</html>
