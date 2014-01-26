<?php
require_once 'libs/db.php';
require_once 'libs/models/user.php';

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
