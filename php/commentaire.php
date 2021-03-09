<?php
  function PrintCommentaire($commentaire){
    // Print un commentaire selon un objet SQL (Voir liste_commentaires.php)

    require_once("class_user.php");
    require_once("profil.php");

    // On génère un objet user depuis son id et on prend son pseudonyme
  ?>
  <div class="commentaire">
    <div class="commentaire_meta">
      <div class="commentaire_auteur"> <?php PrintProfil($commentaire["id_utilisateur"]); ?></div>
      <p class="commentaire_date"> <?php echo $commentaire["date_publication"]; ?></p>
      <p class="commentaire_message"> <?php echo $commentaire["message"]; ?></p>
    </div>
  </div>
  <?php
  }

  function AddCommentaire($id_video, $message){
    // Ajoute un commentaire (Juste besoin de l'id video et du message, le reste est automatique !

    require("init_sql.php"); // On initialise la base de données
    $statement = $DATABASE->prepare("INSERT INTO commentaire(id_video, id_utilisateur, message) VALUES (?, ?, ?)"); // Commande SQL
    $statement->execute(array($id_video, $_SESSION["id_utilisateur"], $message));

    return $statement; // On retourne vrai ou faux selon le succès de la commande
  }
 ?>
