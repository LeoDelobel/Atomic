<?php
  class User{
    public $id_utilisateur;
    public $id_role;
    public $pseudonyme;
    public $mail;

    function __construct($id_utilisateur, $id_role, $pseudonyme, $mail){
      $this->id_utilisateur = htmlspecialchars($id_utilisateur);
      $this->id_role = htmlspecialchars($id_role);
      $this->pseudonyme = htmlspecialchars($pseudonyme);
      $this->mail = htmlspecialchars($mail);
    }
  }

  class UserManager{

    # Connexion et retour du succès de la fonction (true, false)
    static public function Connexion($name, $pass){
      session_start();
      require("init_sql.php");
      $statement = $DATABASE->prepare("SELECT * FROM utilisateur WHERE pseudonyme = ?");
      $statement->execute(array($name));
      $compte = $statement->fetchAll()[0];

      if(isset($compte)){
        # Le compte existe (Les noms correspondent)
        if($compte["pass"] == md5($pass)){
          # Le compte est correct, authentification
          # On remplit le $_SESSION avec un objet utilisateur

          $_SESSION["auth"] = true;
          $_SESSION["pseudonyme"] = $compte["pseudonyme"];
          $_SESSION["id_utilisateur"] = $compte["id_utilisateur"];
          $_SESSION["id_role"] = $compte["id_role"];

          # On retourne true (Donc tout s'est bien passé)
          return true;
        } else {
          # Mot de passe incorrect
          return false;
        }
      } else {
        # Le compte n'existe pas
        return false;
      }
    }
    static public function Inscription($name, $pass, $mail){
      session_start();
      require_once("init_sql.php");

      # L'ID role est 1 par défaut (Rang utilisateur)
      $statement = $DATABASE->prepare("INSERT INTO utilisateur(id_role, pseudonyme, pass, mail) VALUES (1, ?, ?, ?)");

      # On met le execute dans un return car il donne un true ou false
      return($statement->execute(array($name, md5($pass), $mail)));
    }

    static public function FindUser($id_utilisateur){
      session_start();
      require("init_sql.php");
      $statement = $DATABASE->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ?");
      $statement->execute(array($id_utilisateur));
      $compte = $statement->fetchAll()[0];

      if(isset($compte)){
        # Le compte existe (L'id est valide)

        # On rend un objet utilisateur avec toutes ses données
          return new User(
            $compte["id_utilisateur"],
            $compte["id_role"],
            $compte["pseudonyme"],
            $compte["mail"]);
      } else {
        # Le compte n'existe pas
        return false;
      }
    }

    static public function PrintProfil($utilisateur){
      // La fonction ne prend que des objets Utilisateur !

      // $utilisateur = UserManager::FindUser($id_utilisateur); -- OBSOLETE
      
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
          <?php
          require_once("abonnes.php");
          if($_SESSION["auth"]){
                // Si l'utilisateur est connecté
              if(CheckAbonnement($utilisateur->id_utilisateur, $_SESSION["id_utilisateur"])){ ?>
              <input class="abonnement_button_y" type="submit" name="abonnement" value="Abonné">
            <?php } else {
              ?>
              <input class="abonnement_button_n" type="submit" name="abonnement" value="S'abonner">
              <?php
            }
          }
        ?>
        </a>
      </div>

      <?php
    }
  }
 ?>
