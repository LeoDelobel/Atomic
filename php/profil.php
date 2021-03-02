<?php
  function PrintProfil($id_utilisateur){
    include("init_sql.php");
    require_once("class_user.php");

    $utilisateur = UserManager::FindUser($id_utilisateur);
    require_once("abonnes.php");
    ?>

    <span class="profil">
      <img class="profil_img" src="res/miniatures/<?php echo $video["id_video"] ?>.jpg">
      <div class="profil_meta">
        <p class="profil_nom"> <?php echo $utilisateur->pseudonyme ?></p>
        <p class="profil_abonnes"> <?php echo GetAbonnes($id_utilisateur) ?> abonnés</p>
        <a href="php/validation.php?id_master=<?php echo $utilisateur->id_utilisateur?>">
          <input type="submit" name="abonnement" value="S'abonner">
        </form>
      </div>
    </span>

    <?php
  }
?>
