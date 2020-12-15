<?php
  class User{
    public $id_utilisateur;
    public $id_role;
    public $pseudonyme;
    public $mail;

    function __construct($id_utilisateur, $id_role, $pseudonyme, $mail){
      $this->id_utilisateur = $id_utilisateur;
      $this->$id_role = $id_role;
      $this->$pseudonyme = $pseudonyme;
      $this->$mail = $mail;
    }
  }

  class UserManager{
    static function Connexion($name, $pass){
      require_once("init_sql.php");
      $statement = $DATABASE->prepare("SELECT * FROM utilisateur WHERE pseudonyme = ?");
      $statement->execute(array($name));
      $compte = $statement->fetchAll()[0];

      if(isset($compte)){
        # Le compte existe (Les noms correspondent)
        if($compte["pass"] == md5($pass)){
          # Le compte est correct, authentification
          # On remplit le $_SESSION avec un objet utilisateur

          $_SESSION["auth"] = true;
          $_SESSION["user"] = new User(
            $compte["id_utilisateur"],
            $compte["id_role"],
            $compte["pseudonyme"],
            $compte["mail"]);

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
  }
 ?>
