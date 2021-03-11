<?php
  require "header.php";
  require "php/init_sql.php"
?>
<html>
<head> <!-- ______________ HEAD _______________________________________________________________________________________________________-->
  <link rel ="stylesheet" href = "css/style_connexion.css"/>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
  <div class="page_connexion">
    <?php
    if(isset($_POST['btn_connexion'])) #Check si le bouton de connexion est utilisé (évite le conflit avec inscription)
    {
      if(isset($_POST['pseudo'])) #Check si pseudo est rempli
      {
        if(isset($_POST['pwd'])) #Check si password est rempli + requête sql
      {
        # On utilise UserManager
        # La fonction renvoie true si l'utilisateur est connecté
        require_once("php/class_user.php");
        if(UserManager::Connexion($_POST['pseudo'], $_POST['pwd'])){
          echo 'Bonjour '.$_POST['pseudo'];

          # Si la fonction renvoie true
        } else {
          # Afficher le message d'Erreur
          echo 'Erreur de connexion';
        }
      } # erreur empty
    }  # erreur empty
  }
    ?>



  <div class='row rangement'>
    <form method="POST" action="./connexion.php">

      <div class="container-fluid connexion_area">
        <div class="row">

          <div class="container-fluid">
            <h1>Connexion</h1>
          </div>
        </div>
        <div class="row">
          <div class="container-fluid pseudo">
            <h3>Pseudo : </h3>
          </div>
          <div class="container-fluid input_pseudo">
            <input type="text" name="pseudo" />
          </div>

        </div>
        <div class="row">

          <div class="container-fluid col-sm-auto password">
            <h3>Mot de passe :</h3>
          </div>
          <div class="container-fluid col-sm-auto input_pwd">
            <input type="text" name="pwd" />
          </div>

        </div>
        <div class="row">
          <div class="container-fluid">
            <input type="submit" name="btn_connexion" value="Se connecter" />
         </div>
        </div>
      </div>
    </form>

<!--Inscription zone -->

    <div class="row">
      <form method="POST" action="./connexion.php">

      <div class="container-fluid col-sm-auto inscription_area">
        <div class="row">

          <div class="container-fluid">
            <h1>Inscription</h1>
          </div>
        </div>
        <div class="row">
          <div class="container-fluid pseudo">
            <h3>Pseudo : </h3>
          </div>
          <div class="container-fluid input_pseudo">
            <input type="text" name="ins_pseudo" />
          </div>

        </div>
        <div class="row">

          <div class="container-fluid password">
            <h3>Mot de passe :</h3>
          </div>
          <div class="container-fluid input_pwd">
            <input type="text" name="ins_pwd" />
          </div>
        </div>

        <div class="container-fluid mail">
          <h3>E-mail :</h3>
        </div>
        <div class="container-fluid input_pwd">
          <input type="text" name="ins_mail" />
        </div>
      </div>

      <div new="container-fluid consent1">
        <input type="checkbox" name="ins_18" />
        <p>Je certifie que je suis agé·e·s de plus de 18 ans</p>
      </div>

      <div new="container-fluid consent1">
        <input type="checkbox" name="ins_conditionsgene" />
        <p>Je certifie avoir lu les <a>Conditions général d'utilisation</a> du site Atomic vidéo</p>
      </div>
        <div class="row">
          <div class="container-fluid">
            <input type="submit" name="btn_inscription" value="S'incrire" />
         </div>
        </div>
      </div>
    </form>
      <?php
        if(isset($_POST['ins_pseudo']) && isset($_POST['ins_pwd']) && isset($_POST['ins_mail']))
        {
          if(isset($_POST['ins_conditionsgene']) && isset($_POST['ins_18']))
          {
            $statement= $DATABASE->prepare("INSERT INTO utilisateur (id_role,pseudonyme,pass,mail) VALUES (1,?,?,?)");
            $hached=md5($_POST['ins_pseudo']);
            $statement->execute(array($_POST['ins_pseudo'],$hached,$_POST['ins_mail']));
          }
        }
      ?>
</div>




</body>
</html>
