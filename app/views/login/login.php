<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RainbowProject</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= URL ?>assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= URL ?>assets/css/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
	  
      <form method="post" class="form-signin" role="form">
        <h2 class="form-signin-heading">Rainbow Project</h2>
		<?php if (!empty($data->error)): ?>
		  <div class="alert alert-danger">Virhe! <?php echo $data->error; ?></div>
        <?php endif; ?>
        <input type="text" name="username" class="form-control" placeholder="Käyttäjätunnus" value="<?= $data->username ?>" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Salasana" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Kirjaudu</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
