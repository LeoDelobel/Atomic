<?php
class Categorie {

  # Variables
  public $id_categorie;
  public $description;

  # Constructeur
  function __construct($id_categorie, $description){
    $this->id_categorie = $id_categorie;
    $this->description = $description;
  }
}

class CategorieManager {
  # Retourne un objet Categorie selon l'id passé en paramètre ($id_categorie)
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

  # Retourne une liste de toutes les catégories
  static public function GetAll(){
    require("./php/init_sql.php");
    # On demande à la base de données toutes les catégories
    $statement = $DATABASE->prepare("SELECT * FROM categorie");
    $statement->execute();
    $liste_categories = $statement->fetchAll();

    # On crée la liste de catégories
    $resultat = array();
    foreach($liste_categories as $categorie){ # Pour chaque catégorie donnée par le SQL,
      # On ajoute à la liste un objet Categorie construit sur le tas
      array_push($resultat, new Categorie($categorie['id_categorie'], $categorie['description']));
    }

    # On retourne la liste
    return $resultat;
  }

  static public function GetIDs(){
    require("./php/init_sql.php");
    # On demande à la base de données toutes les catégories
    $statement = $DATABASE->prepare("SELECT id_categorie FROM categorie");
    $statement->execute();
    $liste_categories = $statement->fetchAll();

    # On crée la liste de catégories
    $resultat = array();
    foreach($liste_categories as $categorie){ # Pour chaque catégorie donnée par le SQL,
      # On ajoute à la liste un objet Categorie construit sur le tas
      array_push($resultat, $categorie["id_categorie"]);
    }

    # On retourne la liste
    return $resultat;
  }

  # Ajoute une catégorie
  static public function Add($description){
    require("./php/init_sql.php");
    # On ajoute une catégorie à partir de la description (l'id est auto incrémentée par la base de données)
    $statement = $DATABASE->prepare("INSERT INTO categorie(description) VALUES (?)");
    $statement->execute(array($description));

    # Si tout se passe bien, on renvoie true
    return true;
  }
}
?>
