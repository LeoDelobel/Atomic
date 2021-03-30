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

  class LikeManager{
    static public function RemoveLike($id_utilisateur, $id_video){
      // Supprime tous les likes (un seul en théorie) d'un utilisateur sur une vidéo donnée

      require("init_sql.php"); // On initialise la base de données
      $statement = $DATABASE->prepare("DELETE FROM liker WHERE id_utilisateur = ? AND id_video = ?"); // Commande SQL
      $statement->execute(array($id_utilisateur, $id_video));

      return $statement; // On retourne vrai ou faux selon le succès de la commande
    }

    static public function AddLike($id_utilisateur, $id_video){
      // La fonction ne fait qu'ajouter un like, elle ne vérifie pas si il est déjà mit !

      require("init_sql.php"); // On initialise la base de données
      $statement = $DATABASE->prepare("INSERT INTO liker(id_utilisateur, id_video) VALUES (?, ?)"); // Commande SQL
      $statement->execute(array($id_utilisateur, $id_video));

      return $statement; // On retourne vrai ou faux selon le succès de la commande
    }

    static public function CheckLike($id_utilisateur, $id_video){
      // Retourne vrai si l'utilisateur a déjà liké une certaine vidéo

      require("init_sql.php"); // On initialise la base de données

      // -- On prend le nombre de likes sur une vidéo avec l'id de l'utilisateur
      $statement = $DATABASE->prepare("SELECT COUNT(id_video) AS nombre FROM liker WHERE id_utilisateur = ? AND id_video = ?"); // Commande SQL
      $statement->execute(array($id_utilisateur, $id_video));
      $like = $statement->fetchAll()[0];
      return ($like[0] > 0); // On retourne vrai si l'utilisateur a un ou plusieurs likes enregistrées sur cette vidéo
    }

    static public function GetLikes($id_video){
      // Retourne le nombre de likes d'une vidéo

      require("init_sql.php");
      $statement = $DATABASE->prepare("SELECT COUNT(id_video) AS nombre FROM liker WHERE id_video = ?"); // Commande SQL
      $statement->execute(array($id_video));
      $compte = $statement->fetchAll()[0];

      return $compte["nombre"]; // On retourne le nombre de likes
    }
  }

  class VueManager{
    static public function GetVues($id_video){
      // Récupère le nombre de vues d'une vidéo donnée

      require("init_sql.php");

      $statement = $DATABASE->prepare("SELECT COUNT(id_video) AS nombre FROM visionner WHERE id_video = ?");
      $statement->execute(array($id_video));
      $compte = $statement->fetchAll()[0];

      return $compte["nombre"];
    }

    static public function AddVue($id_video, $id_utilisateur){
      // Ajoute une vue à une vidéo donnée
      // Vérifie la dernière vue pour éviter le spam (Limite de 1 vue par 30 secondes);

      require("init_sql.php");
      // On récupère la dernière vue de l'utilisateur
      $statement = $DATABASE->prepare("SELECT date_visionnage FROM visionner WHERE id_video = ? AND id_utilisateur = ? ORDER BY date_visionnage DESC LIMIT 1");
      $statement->execute(array($id_video, $id_utilisateur));
      $last_vue = $statement->fetchAll()[0]["date_visionnage"];

      $statement = $DATABASE->prepare("INSERT INTO visionner(id_utilisateur, id_video) VALUES (?, ?)");
      $statement->execute(array($id_utilisateur, $id_video));

      if(!$statement){
        // Si la commande SQL a reçu une erreur
        return false;
      } else {
        // Sinon tout va bien
        return true;
      }
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

      $statement = $DATABASE->prepare("SELECT id_video FROM video WHERE id_utilisateur = ? ORDER BY date_publication DESC LIMIT 5");
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
