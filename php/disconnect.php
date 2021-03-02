<?php
  if(isset($_POST)){
    session_destroy();
    header('Location: ../index.php');
  }
 ?>
