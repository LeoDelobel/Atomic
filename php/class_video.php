<?php
  class Video{
    public $id_video;
    public $id_utilisateur;
    public $id_categorie;
    public $date_publication;
    public $titre;
    public $description;

    function __construct(
      $id_video, $id_utilisateur, $id_categorie, $date_publication, $titre, $description
    ){
      $this->$id_video = $id_video;
      $this->$id_utilisateur = $id_utilisateur;
      $this->$id_categorie = $id_categorie;
      $this->$date_publication = $date_publication;
      $this->$titre = $titre;
      $this->$description = $description;
    }
  }

  class VideoManager{
    static public function GetById($id_video){
      require("./php/init_sql.php");
      # On demande à la base de données quelles vidéos ont l'id donnée
      $statement = $DATABASE->prepare("SELECT * FROM video WHERE id_video = ?");
      $statement->execute(array($id_video));

      # On extrait une seule vidéo
      $categorie = $statement->fetchAll()[0];

      # On retourne directement un objet vidéo
      // ------------ A FAIRE -----------
      return new Video();
    }
    static public function AddVideo($id_utilisateur, $id_categorie, $titre, $description){
      // Ajoute une nouvelle vidéo dans la base de données (Ne nettoie pas les input !)

      require("./php/init_sql.php");

      $statement = $DATABASE->prepare("INSERT INTO video(id_utilisateur, id_categorie, titre, description) VALUES(?, ?, ?, ?)");
      $statement->execute(array($id_utilisateur, $id_categorie, $titre, $description));
      print_r($statement->errorInfo());

      $resultat = [];
      $resultat["success"] = $statement;

      $statement = $DATABASE->prepare("SELECT id_video FROM video WHERE id_utilisateur = ? ORDER BY date_publication DESC");
      $statement->execute(array($id_utilisateur));
      $video = $statement->fetchAll()[0];

      $resultat["id_video"] = $video["id_video"];

      // On retourne vrai ou faux
      return $resultat;
    }
  }
 ?>
