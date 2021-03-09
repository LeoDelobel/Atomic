<?php
class Tag {
  # Variables privées
  private var $id_tag;
  private var $id_video;
  private var $libelle;

  # Constructeur
  function __construct($id_tag, $id_video, $libelle){
    $this->id_tag = $id_tag;
    $this->libelle = $libelle;
    $this->id_video = $id_video;
  }
}

class TagManager(){
  # On appelle la base de données
  include("./init_sql.php");

  # Retourne un objet Tag selon l'id passé en paramètre ($id_tag)
  static public function GetById($id_tag){
    # On demande à la base de données quels tags ont la même id
    $statement = $DATABASE->prepare("SELECT * FROM tag WHERE id_tag = ?");
    $statement->execute(array($id_tag));

    # On extrait un seul tag
    $tag = $statement->fetchAll()[0];

    # On retourne directement un objet Tag créé à partir de la requête SQL ($tag)
    return new Tag($tag['id_tag'], $tag['id_video'], $tag['libelle']);
  }

  static public function GetByVideo($id_video){
    $statement = $DATABASE->prepare("SELECT * FROM tag WHERE id_video = ?");
    $statement->execute(array($id_video));

    $liste_tags = $statement->fetchAll();

    $resultat = array();
    foreach($liste_tags as $tag){
      array_push($resultat, new Tag($tag['id_tag'], $tag['id_video'], $tag['libelle']));
    }

    return $resultat;
  }
}
