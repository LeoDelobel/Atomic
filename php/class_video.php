<?php
  class Video{
    public $id_video;
    public $id_utilisateur;
    public $id_categorie;
    public $date_publication;
    public $nombre_likes;
    public $nombre_vues;
    public $titre;
    public $description;

    function __construct(
      $id_video, $id_utilisateur, $id_categorie, $date_publication,
      $nombre_likes, $nombre_vues, $titre, $description
    ){
      $this->$id_video = $id_video;
      $this->$id_utilisateur = $id_utilisateur;
      $this->$id_categorie = $id_categorie;
      $this->$date_publication = $date_publication;
      $this->$nombre_likes = $nombre_likes;
      $this->$nombre_vues = $nombre_vues;
      $this->$titre = $titre;
      $this->$description = $description;
    }
  }

  class VideoManager{
    static public function GetById($id_categorie){
      require("./php/init_sql.php");
      # On demande à la base de données quelles catégories ont la même id
      $statement = $DATABASE->prepare("SELECT * FROM categorie WHERE id_categorie = ?");
      $statement->execute(array($id_categorie));

      # On extrait une seule catégorie
      $categorie = $statement->fetchAll()[0];

      # On retourne directement un objet Categorie créé à partir de la requête SQL ($categorie)
      return new Categorie($categorie['id_categorie'], $categorie['description']);
    }
  }
 ?>
