<?php
require_once 'config.php';

$users = User::getUsers();
?><!DOCTYPE HTML>
<html>
  <head><title>Otsikko</title></head>
  <body>
    <h1>Listaelementtitesti</h1>
    <ul>
    <?php foreach($users as $user) : ?>
	<li><?php echo $user->getUsername(); ?></li>
    <?php endforeach; ?>
    </ul>
  </body>
</html>
