
<html> <!-- ______________ HEAD _______________________________________________________________________________________________________-->
  <link rel ="stylesheet" href = "css/style_connexion.css"/>
  <?php
    require "header.php";
    require "php/init_sql.php"
  ?>
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
          header('Location: index.php');

          # Si la fonction renvoie true
        } else {
          # Afficher le message d'Erreur
          echo 'Erreur de connexion';
        }
      } # erreur empty
    }  # erreur empty
  }
    ?>
    <div class="hello">
    <div class="fond_selecteur">
      <a class="sel_connexion" href="#" onclick="connexion()" >Connexion</a>
      <a class="sel_inscription" href="#" onclick="inscription()">Inscription</a>
    </div>
  </div>
    <form method="POST" action="./connexion.php" class="connect_area">

            <input type="text" name="pseudo" class="inp_pseudo_conn" placeholder="Nom d'utilisateur" required/>

            <input type="password" name="pwd" class="pwd" placeholder="Mot de passe" required/>

            <input type="submit" name="btn_connexion" value="Se connecter" id="btn_connexion" />
    </form>
<!--Inscription zone -->
<!--
    <div class="row">
      <form method="POST" action="./connexion.php">

            <input type="text" name="ins_pseudo" />

            <input type="password" name="ins_pwd" />

            <input type="text" name="ins_mail" />

            <input type="checkbox" name="ins_18" />
              <p>Je certifie que je suis agé·e·s de plus de 18 ans</p>

            <input type="checkbox" name="ins_conditionsgene" />
              <p>Je certifie avoir lu les <a>Conditions général d'utilisation</a> du site Atomic vidéo</p>

            <input type="submit" name="btn_inscription" value="S'incrire" id="btn_inscription"/>
          </form>
-->
      <?php
        if(isset($_POST['ins_pseudo']) && isset($_POST['ins_pwd']) && isset($_POST['ins_mail']))
        {
          if(isset($_POST['ins_conditionsgene']) && isset($_POST['ins_18']))
          {
            $statement= $DATABASE->prepare("INSERT INTO utilisateur (id_role,pseudonyme,pass,mail) VALUES (1,?,?,?)");
            $hached=md5($_POST['ins_pseudo']);
            $statement->execute(array($_POST['ins_pseudo'],$hached,$_POST['ins_mail']));
            header('Location: index.php');
          }
        }
      ?>
</div>




</body>
<script>

function connexion()
{
  let radis = document.querySelector(".connect_area");
  let sadiv = document.querySelector(".sel_inscription");
  let ladiv = document.querySelector(".sel_connexion");
  ladiv.style.background = "linear-gradient(0.25turn, rgb(51,171,21), rgb(27, 135, 15))";
  sadiv.style.background = "none";
  radis.style.margin="auto";
}

function inscription()
{
  let radis = document.querySelector(".connect_area");
  let sadiv = document.querySelector(".sel_inscription");
  let ladiv = document.querySelector(".sel_connexion");
  sadiv.style.background = "linear-gradient(0.25turn, rgb(51,171,21), rgb(27, 135, 15))";
  ladiv.style.background = "none";
  radis.style.margin="200%";
}

function problem()
{
  
}



</script>
</html>
