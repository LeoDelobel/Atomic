<?php
# Script Name	: header.php
# Description	: Affichage du header (Barre de recherche, logo, icone de profil)
# Author      : Antoine Gangloff
# URL         : http://176.166.235.56/header.php
 ?>
  <link rel ="stylesheet" href = "css/style_header.css"/>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Goldman&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <div class="container-fluid header"> <!-- header entier class=header -->
    <div class="row allelements"><!-- Tout les éléments (allelements) -->

      <div class="col-sm-1" id="lgAV_area">
        <img src="img/logo.png" id="lgAV"/>
      </div>

      <div class="col-sm-auto" id="titleAV">
        <p><a href="http://176.166.235.56/index.php">Atomic Vidéo</a></p>
      </div>
      <form action="search.php" type="get">
        <input type="text" id="search_bar" name="q" />
        <input type="submit" id="search_button" src="ressources/profile" value="Rechercher"/>
      </form>

        <div class="row grey_area">
          <img src="img/profile.jpeg" id="profile_picture" />
          <p id="account_name_area"><?php

          # Si l'utilisateur est connecté, $_SESSION["auth"] est true
          session_start();
          require_once("php/class_user.php");
          $test = new User("1", "1", "TEST", "mail");
          var_dump($test->pseudonyme);
            if($_SESSION['auth']){
              echo 'Bonjour ' . $test->pseudonyme;
            } else {
              echo '<a href="connexion.php">';
              echo 'Se connecter';
              echo '</a>';
            }
          ?></p>
        </div>

      </div>
    </div>
  </div>
