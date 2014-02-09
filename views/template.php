<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Justified Nav Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=URL?>css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=URL?>css/justified-nav.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <div class="masthead">
		<a class="btn btn-success navbar-right" href="<?=URL?>login/logout/">Kirjaudu ulos</a>
		<h3 class="text-muted"><a href="<?=URL?>">Rainbow Project</a></h3>
		<ul class="nav nav-justified">
          <li><a href="<?=URL?>">Etusivu</a></li>
          <li><a href="#">Projektit</a></li>
          <li><a href="#">Asiakkaat</a></li>
          <li><a href="<?=URL?>user/">Käyttäjät</a></li>
        </ul>
      </div>
	  <?php if (!empty($_SESSION['notice'])): ?>
	  <hr/>
      <div class="col-lg-6 alert alert-success">
		<?php echo $_SESSION['notice']; ?>
		<?php unset($_SESSION['notice']); ?>
	  </div>
	  <?php endif; ?>
	  
	  <?php if (!empty($data->error)): ?>
		<div class="alert alert-danger">Virhe! <?php echo $data->error; ?></div>
      <?php endif; ?>
	  
      <?php require VIEW_PATH . $page . ".php"; ?>
      <!-- Site footer -->
      <div class="footer">
        <p>&copy; Rainbow Project 2013</p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
