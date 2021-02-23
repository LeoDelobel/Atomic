<?php
  try{
  $DATABASE = new PDO('mysql:dbname=atomic;host=127.0.0.1','atomic','NK5SjKJj');
  $DATABASE->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
  }
 ?>
