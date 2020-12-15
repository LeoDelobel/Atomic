<?php
  require "init_sql.php";
  $sth = $DATABASE->prepare("INSERT INTO video(titre, nombreVues) VALUES(?,?)");
  $sth->execute(array('Top 10 des top 10','3'));
  print_r($DATABASE->errorInfo());
?>
