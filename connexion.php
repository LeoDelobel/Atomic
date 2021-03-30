
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
      <form method="POST" action="./connexion.php" class="insc_area">

            <input type="text" class="inp_pseudo_conn" name="ins_pseudo" placeholder="Nom d'utilisateur" required />

            <input type="text" name="ins_mail" class="mail" placeholder="E-mail" required/>

            <input type="password" name="ins_pwd" class="pwd" placeholder="Mot de passe" required/>

            <input type="submit" name="btn_inscription" value="S'inscrire" id="btn_inscription"/>
          </form>
<div class="hello2">
<div class="erreur">
  <p>Vos informations sont éronnés, veuillez réessayer.</p>
<div>
</div>

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

function inscription()
{
  let connect_area = document.querySelector(".connect_area");
  let sel_inscription = document.querySelector(".sel_inscription");
  let sel_connexion = document.querySelector(".sel_connexion");
  let insc_area = document.querySelector(".insc_area");
  sel_inscription.style.background = "linear-gradient(0.25turn, rgb(51,171,21), rgb(27, 135, 15))";
  sel_connexion.style.background = "none";

  insc_area.style.display = "block";
  connect_area.style.display = "none";

}

function connexion()
{
  let connect_area = document.querySelector(".connect_area");
  let sel_inscription = document.querySelector(".sel_inscription");
  let sel_connexion = document.querySelector(".sel_connexion");
  let insc_area = document.querySelector(".insc_area");
  sel_connexion.style.background = "linear-gradient(0.25turn, rgb(51,171,21), rgb(27, 135, 15))";
  sel_inscription.style.background = "none";

  insc_area.style.display="none";
  connect_area.style.display="block";


}

function problem()
{
  let connect_area = document.querySelector(".connect_area");
  connect_area.style.box-shadow = "7px 7px 7px black;"
}


</script>
</html>
