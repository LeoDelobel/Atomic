<?php
  function PrintCommentaire($commentaire){
    // Print un commentaire selon un objet SQL (Voir liste_commentaires.php)

    require_once("class_user.php");

    // On génère un objet user depuis son id et on prend son pseudonyme
  ?>
  <span class="commentaire">
    <div class="commentaire_meta">
      <p class="commentaire_auteur"> <?php echo UserManager::FindUser($commentaire["id_utilisateur"])->pseudonyme; ?></p>
      <p class="commentaire_date"> Le : <?php echo $commentaire["date_publication"]; ?></p>
      <p class="commentaire_message"> <?php echo $commentaire["message"]; ?></p>
    </div>
  </span>
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
