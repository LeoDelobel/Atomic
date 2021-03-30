<link rel="stylesheet" href="../css/style_index.css"/>
<link rel="stylesheet" href="../css/style_header.css"/>

<?php
  session_start();
  require_once("class_user.php");

  require_once("../header.php");

  // Redirection -- OBSOLETE
  // header('Location: ../index.php');

  if(AbonnementManager::CheckAbonnement(htmlspecialchars($_GET["id_master"]),$_SESSION["id_utilisateur"])){
    // L'utilisateur est déjà abonné, on se désabonne
    if(AbonnementManager::RemoveAbonnement(htmlspecialchars($_GET["id_master"]),$_SESSION["id_utilisateur"])){
    ?>
      <p>Vous êtes maintenant abonné à <?php echo UserManager::FindUser(htmlspecialchars($_GET["id_master"]))->pseudonyme; ?> !</p>
    <?php
    }
  } else {
    // Sinon on s'abonne normalement
    if(AbonnementManager::AddAbonnement(htmlspecialchars($_GET["id_master"]),$_SESSION["id_utilisateur"])){
    ?>
      <p>Vous n'êtes plus abonné à <?php echo UserManager::FindUser(htmlspecialchars($_GET["id_master"]))->pseudonyme; ?> !</p>
    <?php
    }
  }
?>

<a href="../index.php"><button>Revenir au menu</button></a>
