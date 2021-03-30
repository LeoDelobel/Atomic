<?php
  class Video{
    public $id_video;
    public $id_utilisateur;
    public $id_categorie;
    public $date_publication;
    public $titre;
    public $description;
    public $img_type;

    function __construct(
      $id_video, $id_utilisateur, $id_categorie, $date_publication, $titre, $description, $img_type
    ){
      $this->id_video = $id_video;
      $this->id_utilisateur = $id_utilisateur;
      $this->id_categorie = $id_categorie;
      $this->date_publication = $date_publication;
      $this->titre = $titre;
      $this->description = $description;
      $this->img_type = $img_type;
    }
  }

  class VideoManager{
    static public function AddVideo($id_utilisateur, $id_categorie, $titre, $description, $img_type){
      // Ajoute une nouvelle vidéo dans la base de données (Ne nettoie pas les input !)

      require("./php/init_sql.php");

      $statement = $DATABASE->prepare("INSERT INTO video(id_utilisateur, id_categorie, titre, description, img_type) VALUES(?, ?, ?, ?, ?)");
      $statement->execute(array($id_utilisateur, $id_categorie, $titre, $description, $img_type));
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

    static public function GetById($id_video){
      require("./php/init_sql.php");
      # On demande à la base de données quelles vidéos ont l'id donnée
      $statement = $DATABASE->prepare("SELECT * FROM video WHERE id_video = ?");
      $statement->execute(array($id_video));

      # On extrait une seule vidéo
      $video = $statement->fetchAll()[0];

      # On retourne directement un objet vidéo
      // ------------ A FAIRE -----------
      // On remercie l'auteur de la ligne précédente qui avait tout oublié depuis
      // Merci monseigneur

      return new Video($video['id_video'],
      $video['id_utilisateur'],
      $video['id_categorie'],
      $video['date_publication'],
      $video['titre'],
      $video['description'],
      $video['img_type']);
    }
    static public function GetHaving($recherche){
      include("init_sql.php");

      $statement = $DATABASE->prepare("SELECT video.id_video, video.id_utilisateur, count(visionner.id_video) as vues FROM video INNER JOIN visionner ON video.id_video = visionner.id_video WHERE video.titre LIKE ? GROUP BY video.id_video ORDER BY vues DESC");
      $statement->execute(array('%' . $recherche . '%'));

      $liste_id = $statement->fetchAll();

      // On va transformer les id en objets Video
      $resultat = array();
      foreach($liste_id as $id){
        array_push($resultat, VideoManager::GetById($id["id_video"]));
      }

      // On peut alors envoyer le tableau dans PrintVideos
      return $resultat;
    }
    static public function GetMostPopularVideos(){
      // Pour une certaine raison, la fonction ne prend que les ID des vidéos les plus regardées

      require 'php/init_sql.php';
      $statement = $DATABASE->prepare("SELECT video.id_video, count(visionner.id_video) AS vues FROM video INNER JOIN visionner ON video.id_video = visionner.id_video GROUP BY id_video ORDER BY vues DESC LIMIT 5");
      $statement->execute();
      #Hello
      $liste_id = $statement->fetchAll();

      // On va transformer les id en objets Video
      $resultat = array();
      foreach($liste_id as $id){
        array_push($resultat, VideoManager::GetById($id["id_video"]));
      }

      // On peut alors envoyer le tableau dans PrintVideos
      return $resultat;
    }
    static public function GetRecentVideos(){
      // Demande les 5 dernières vidéos

      require 'php/init_sql.php';
      $statement = $DATABASE->prepare("SELECT id_video FROM video WHERE date(date_publication) = CURDATE() ORDER BY date_publication DESC LIMIT 5");
      $statement->execute();
      #Hello
      $liste_id = $statement->fetchAll();

      // On va transformer les id en objets Video
      $resultat = array();
      foreach($liste_id as $id){
        array_push($resultat, VideoManager::GetById($id["id_video"]));
      }

      // On peut alors envoyer le tableau dans PrintVideos
      return $resultat;
    }

    static public function GetByUser($id_utilisateur){
      // Demande les 5 dernières vidéos postées par l'utilisateur

      include("init_sql.php");

      $statement = $DATABASE->prepare("SELECT id_video FROM video WHERE id_utilisateur = ? GROUP BY id_utilisateur ORDER BY date_publication DESC LIMIT 5");
      $statement->execute(array($id_utilisateur));

      $liste_id = $statement->fetchAll();

      // On va transformer les id en objets Video
      $resultat = array();
      foreach($liste_id as $id){
        array_push($resultat, VideoManager::GetById($id["id_video"]));
      }

      // On peut alors envoyer le tableau dans PrintVideos
      return $resultat;
    }

    static public function PrintVideos($liste){
      // Fait une liste de miniatures basée sur une liste d'objets Video
      // On commence la liste des vidéos
      require_once('miniature.php');

        ?>
      <div class="liste_videos">
      <ul>
        <?php
      foreach($liste as $video){
        ?>
        <li style="display:inline-block">
          <?php
          // On passe l'objet à printMiniature()
          printMiniature($video);
          ?>
        </li>
      <?php
      }
      ?>
        </ul>
      </div>
      <?php
    }
  }
 ?>
