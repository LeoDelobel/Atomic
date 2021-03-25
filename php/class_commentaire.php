<?php
class Commentaire {

  # Variables
  public $id_commentaire;
  public $id_video;
  public $id_utilisateur;
  public $date_publication;
  public $message;

  # Constructeur
  function __construct($id_commentaire, $id_video, $id_utilisateur, $date_publication, $message){
    $this->id_commentaire = $id_commentaire;
    $this->id_video = $id_video;
    $this->id_utilisateur = $id_utilisateur;
    $this->date_publication = $date_publication;
    $this->message = $message;
  }
}

class CommentaireManager {
  # Retourne un objet Categorie selon l'id passé en paramètre ($id_categorie)
  static public function GetById($id_commentaire){
    require("./php/init_sql.php");
    # On demande à la base de données quel commentaire a la même id
    $statement = $DATABASE->prepare("SELECT * FROM commentaire WHERE id_commentaire = ?");
    $statement->execute(array($id_commentaire));

    # On extrait un seul commentaire (En espérant n'en avoir qu'un de base)
    $commentaire = $statement->fetchAll()[0];

    # On retourne directement un objet Commentaire créé à partir de la requête SQL ($commentaire)
    return new Commentaire(
      $commentaire['id_commentaire'],
      $commentaire['id_video'],
      $commentaire['id_utilisateur'],
      $commentaire['date_publication'],
      $commentaire['message']);
  }

  # Retourne une liste de toutes les catégories
  static public function GetByVideo($id_video){
    require("./php/init_sql.php");
    # On demande à la base de données tous les commentaires selon l'id d'une vidéo
    $statement = $DATABASE->prepare("SELECT * FROM commentaire WHERE id_video = ?");
    $statement->execute(array($id_video));
    $liste_commentaires = $statement->fetchAll();

    # On crée la liste de commentaires
    $resultat = array();
    foreach($liste_commentaires as $commentaire){ # Pour chaque commentaire donnée par le SQL,
      # On ajoute à la liste un objet Commentaire construit sur le tas
      array_push($resultat, new Commentaire(
        $commentaire['id_commentaire'],
        $commentaire['id_video'],
        $commentaire['id_utilisateur'],
        $commentaire['date_publication'],
        $commentaire['message']));
    }

    # On retourne la liste des commentaires
    return $resultat;
  }

  static public function PrintCommentaire($commentaire){
    // Print un commentaire selon un objet SQL (Voir ci dessus)

    require_once("class_user.php");
    require_once("profil.php");

    // On génère un objet user depuis son id et on prend son pseudonyme
  ?>
  <div class="commentaire">
    <div class="commentaire_meta">
      <div class="commentaire_auteur"> <?php PrintProfil($commentaire->id_utilisateur); ?></div>
      <p class="commentaire_date"> <?php echo $commentaire->date_publication; ?></p>
      <p class="commentaire_message"> <?php echo $commentaire->message; ?></p>
      <?php
      if($_SESSION["id_role"] >= 2) {
        // L'utilisateur connecté est un modérateur ou plus
        ?>
        <form action="" method="post">
          <input type="text" name="id_commentaire" value="<?php echo $commentaire->id_commentaire ?>" style="visibility: collapse;">
          <input type="submit" name="delete_com" value="Supprimer" />
        </form>
        <?php
          }
      ?>
    </div>
  </div>
  <?php
  }

  static public function AddCommentaire($id_video, $id_utilisateur, $message){
    require("./php/init_sql.php");
    # On ajoute un nouveau commentaire à la base de données

    $statement = $DATABASE->prepare("INSERT INTO commentaire(id_video, id_utilisateur, message) VALUES(?, ?, ?)");
    $statement->execute(array($id_video, $id_utilisateur, $message));

    // On retourne true ou false selon le succès de la commande
    return $statement;
  }

  static public function RemoveCommentaire($id_commentaire){
    require("./php/init_sql.php");
    # On ajoute un nouveau commentaire à la base de données

    $statement = $DATABASE->prepare("DELETE FROM commentaire WHERE id_commentaire = ?");
    $statement->execute(array($id_commentaire));

    // On retourne true ou false selon le succès de la commande
    return $statement;
  }

  static public function PrintCommentaires($id_video){
    $liste_commentaires = CommentaireManager::GetByVideo($id_video);

    foreach ($liste_commentaires as $commentaire){
      CommentaireManager::PrintCommentaire($commentaire);
    }
  }
}
?>
