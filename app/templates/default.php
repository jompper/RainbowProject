<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
		<?= $this->title; ?>
	</title>

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
    <link href="<?=URL?>assets/css/justified-nav.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <div class="masthead">
		<a class="navbar-right" href="<?=URL?>login/logout/">Kirjaudu ulos</a>
		<h3 class="text-muted"><a href="<?=URL?>">Rainbow Project</a></h3>
		<ul class="nav nav-justified">
          <li><a href="<?=URL?>">Etusivu</a></li>
          <li><a href="<?=URL?>projects/">Projektit</a></li>
          <li><a href="<?=URL?>customers/">Asiakkaat</a></li>
          <li><a href="<?=URL?>user-task-hours/">Työtunnit</a></li>
		  <?php if($_SESSION['admin']): ?>
          <li><a href="<?=URL?>users/">Käyttäjät</a></li>
		  <?php endif; ?>
		  <li><a href="<?=URL?>users/profile">Omat tiedot</a></li>
        </ul>
      </div>
	  <?php if (!empty($_SESSION['notice'])): ?>
	  <hr/>
      <div class="alert alert-success">
		<?php echo $_SESSION['notice']; ?>
		<?php unset($_SESSION['notice']); ?>
	  </div>
	  <?php endif; ?>
	  <?php if (!empty($_SESSION['error'])): ?>
	  <hr/>
      <div class="alert alert-danger">
		<?php echo $_SESSION['error']; ?>
		<?php unset($_SESSION['error']); ?>
	  </div>
	  <?php endif; ?>
	  
	  <?php if (!empty($data->error)): ?>
		<div class="alert alert-danger">Virhe! <?php echo $data->error; ?></div>
      <?php endif; ?>
	  
      <?php require $view; ?>
      <!-- Site footer -->
      <div class="footer">
        <p>&copy; Rainbow Project 2014</p>
      </div>
	  <!-- JS -->
	  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    </div> <!-- /container -->
  </body>
</html>
