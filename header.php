<?php
# Script Name	: header.php
# Description	: Affichage du header (Barre de recherche, logo, icone de profil)
# Author      : Antoine Gangloff
# URL         : http://176.166.235.56/header.php
 ?>
  <link rel ="stylesheet" href = "css/style_header.css"/>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Goldman&display=swap" rel="stylesheet">

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <div class="header_background">
      <a href="index.php">Atomic</a>
        <div class="fond"><form action="search.php" type="get"><input type="text" id="search_bar" name="q" /><input type="submit" id="search_button" src="ressources/profile" value="Rechercher"/></div>
      </form>
      <div class="fond2">
        <?php

                  # Si l'utilisateur est connecté, $_SESSION["auth"] est true
                  session_start();
                  require_once("php/class_user.php");
                    if($_SESSION['auth']){

                      echo $_SESSION["pseudonyme"];
                      echo '<button class="upload"><a href="ajout_video.php"><img src="#"/></a></button>';
                      echo'<form class = "form" action="php/disconnect.php" method="POST">
                            <button class="upload">Déconnexion</button>
                      </form>';

                    } else {
                      echo '<a href="connexion.php">';
                      echo 'Se connecter';
                      echo '</a>';
                    }
                  ?>
      </div>

    </div>
  </body>
</html>
