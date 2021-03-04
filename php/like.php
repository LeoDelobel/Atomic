<?php
function RemoveLike($id_utilisateur, $id_video){
  // Supprime tous les likes (un seul en théorie) d'un utilisateur sur une vidéo donnée

  require("init_sql.php"); // On initialise la base de données
  $statement = $DATABASE->prepare("DELETE FROM liker WHERE id_utilisateur = ? AND id_video = ?"); // Commande SQL
  $statement->execute(array($id_utilisateur, $id_video));

  return $statement; // On retourne vrai ou faux selon le succès de la commande
}

function AddLike($id_utilisateur, $id_video){
  // La fonction ne fait qu'ajouter un like, elle ne vérifie pas si il est déjà mit !

  require("init_sql.php"); // On initialise la base de données
  $statement = $DATABASE->prepare("INSERT INTO liker(id_utilisateur, id_video) VALUES (?, ?)"); // Commande SQL
  $statement->execute(array($id_utilisateur, $id_video));

  return $statement; // On retourne vrai ou faux selon le succès de la commande
}

function CheckLike($id_utilisateur, $id_video){
  // Retourne vrai si l'utilisateur a déjà liké une certaine vidéo

  require("init_sql.php"); // On initialise la base de données

  // -- On prend le nombre de likes sur une vidéo avec l'id de l'utilisateur
  $statement = $DATABASE->prepare("SELECT COUNT(id_video) AS nombre FROM liker WHERE id_utilisateur = ? AND id_video = ?"); // Commande SQL
  $statement->execute(array($id_utilisateur, $id_video));
  $like = $statement->fetchAll()[0];
  return ($like[0] > 0); // On retourne vrai si l'utilisateur a un ou plusieurs likes enregistrées sur cette vidéo
}

function GetLikes($id_video){
  // Retourne le nombre de likes d'une vidéo

  require("init_sql.php");
  $statement = $DATABASE->prepare("SELECT COUNT(id_video) AS nombre FROM liker WHERE id_video = ?"); // Commande SQL
  $statement->execute(array($id_video));
  $compte = $statement->fetchAll()[0];

  return $compte["nombre"]; // On retourne le nombre de likes
}
 ?>
