<?php
  require "header.php";
  require "php/init_sql.php";
?>
<html>
<head>
  <link rel ="stylesheet" href = "css/style_upload.css"/>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
  <div class="container-fluid page_upload">
    <div class="row">
      <div class="container-fluid col-sm-15">
        <h1>Ajouter une nouvelle vidéo</h1>
      </div>
    </div>
    <form action="upload.php" method="get">


    <div class="row">
      <div class="container-fluid col-sm-6">
        <h3>Titre de la vidéo :</h3>
      </div>
      <div class="container-fluid col-sm-6 input_titre">
        <input type="text" name="titre"/>
      </div>
    </div>

    <div class="row">
      <div class="container-fluid col-sm-6">
        <h3>Description :</h3>
      </div>
      <div class="container-fluid col-sm-6 input_description">
        <textarea name="description"></textarea>
      </div>

      <div class="row">
        <div class="container-fluid col-sm-6">
          <h3>Catégorie :</h3>
        </div>
        <div class="container-fluid col-sm-6 cmbox_catégorie">
          <?php
            require("php/class_categorie.php");
            $categories = CategorieManager::GetAll();
          ?>
          <select>
            <?php
              foreach($categories as $categorie)
              {
                echo '<option value="' . $categorie->id_categorie . '">';
                echo $categorie->description;
                echo '</option>';
              }
            ?>

          </select>
        </div>
    </div>

    <div class="row">
      <div class="container-fluid col-sm-12">
        <input type="button" value="Poster" />
      </div>
    </div>
    </form>
  </div>
</body>
</html>
