<?php
# Script Name	: header.php
# Description	: Affichage du header (Barre de recherche, logo, icone de profil)
# Author      : Antoine Gangloff
# URL         : http://176.166.235.56/header.php
 ?>


<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel ="stylesheet" href = "css/style_header.css"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Goldman&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="header_background">
      <a class="title"href="index.php">Atomic</a>
        <div class="fond"><form action="search.php" type="get"><input type="text" id="search_bar" name="q" /><input type="submit" id="search_button" src="ressources/profile" value="Rechercher"/></div>
      </form>
      <?php
      session_start();
      require_once("php/class_user.php");
        if($_SESSION['auth']){
          ?>
          <div class="header_list_buttons">
            <button class="header_button"><a href="ajout_video.php"><img src="upload.png" /></a></button>
            <button class="header_button"><a href="ajout_video.php"><img src="cloche.png" /></a></button>
          </div>
          <?php
      }

                  # Si l'utilisateur est connecté, $_SESSION["auth"] est true
                  session_start();
                  require_once("php/class_user.php");
                    if($_SESSION['auth']){
                      ?>

                      <div class="profilbackground">
                        <a class="pseudo"><?php echo $_SESSION["pseudonyme"] ?></a>
                        <form class="helo" action="php/disconnect.php" method="POST"><button class="disconnect">Déconnexion</button></form>
                      </div>
<?php
                    } else {
                      ?>
                      <div class="profilbackground_connexion">
                      <a href="connexion.php">
                        <button class="connexion">Se connecter</button>
                      </a>
                      </div>
<?php
                    }
                  ?>
      </div>

    </div>
  </body>
</html>
