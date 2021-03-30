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

  class AbonnementManager{
    static public function RemoveAbonnement($id_master, $id_slave){
      require("init_sql.php"); // On initialise la base de données
      $statement = $DATABASE->prepare("DELETE FROM abonner WHERE id_master = ? AND id_slave = ?"); // Commande SQL
      $statement->execute(array($id_master, $id_slave));

      return $statement; // On retourne vrai ou faux selon le succès de la commande
    }

    static public function GetAbonnes($id_utilisateur){
      require("init_sql.php");
      $statement = $DATABASE->prepare("SELECT COUNT(id_master) AS nombre FROM abonner WHERE id_master = ?");
      $statement->execute(array($id_utilisateur));
      $compte = $statement->fetchAll()[0];

      return $compte["nombre"];
    }

    static public function CheckAbonnement($id_master, $id_slave){
      // Retourne vrai si l'utilisateur a déjà liké une certaine vidéo

      require("init_sql.php"); // On initialise la base de données

      // -- Drift
      $statement = $DATABASE->prepare("SELECT COUNT(id_master) AS nombre FROM abonner WHERE id_master = ? AND id_slave = ?"); // Commande SQL
      $statement->execute(array($id_master, $id_slave));
      $abonnement = $statement->fetchAll()[0];
      return ($abonnement["nombre"] > 0); // On retourne vrai si l'utilisateur est abonnée
    }

    static public function AddAbonnement($id_master,$id_slave){
      require("init_sql.php");
      $statement = $DATABASE->prepare("INSERT INTO abonner (id_master, id_slave) VALUES (?, ?)");
      $statement->execute(array($id_master,$id_slave));
      $arr = $statement->errorInfo();
      print_r($arr);

      return $statement;
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
      ?>

      <div class="profil">
        <div class="orga">
        <img class="profil_img" src="res/profil/<?php echo $utilisateur->id_utilisateur?>.jpg">
        <div class="info">
          <p class="profil_pseudo"> <?php echo $utilisateur->pseudonyme ?></p>
          <p class="profil_abonnes"> <?php echo AbonnementManager::GetAbonnes($utilisateur->$id_utilisateur) ?> abonnés</p>
        </div>
      </div>
        <a href="php/validation.php?id_master=<?php echo $utilisateur->id_utilisateur?>">
          <?php
          if($_SESSION["auth"]){
                // Si l'utilisateur est connecté
              if(AbonnementManager::CheckAbonnement($utilisateur->id_utilisateur, $_SESSION["id_utilisateur"])){ ?>
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
