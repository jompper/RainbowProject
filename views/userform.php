<div class="row">
	<div class="col-lg-offset-2 col-lg-10">
	  <h2><?=$data->title?></h2>
	</div>
</div>
<?php if(!empty($data->errors)): ?>
	<div class="alert alert-danger col-lg-offset-2 col-lg-10">
		<ul>
		<?php foreach($data->errors as $error): ?>
			<li><?=$error?></li>	
		<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>
<div class="row">
	<div class="col-lg-12">	
		<form method="post" class="form-horizontal" role="form">
		  <div class="form-group">
			<label for="käyttäjätunnus" class="col-sm-2 control-label">Käyttäjätunnus</label>
			<div class="col-sm-10">
				<input type="text" name="username" class="form-control" id="käyttäjätunnus" placeholder="Käyttäjätunnus" value="<?=$data->user->getUsername()?>" required autofocus>
			</div>
		  </div>
		  <div class="form-group">
			<label for="salasana" class="col-sm-2 control-label">Salasana</label>
			<div class="col-sm-10">
				<input type="password" name="password" class="form-control" id="salasana" placeholder="Salasana">
			</div>
		  </div>
		  <div class="form-group">
			<label for="salasana-uudelleen" class="col-sm-2 control-label">Salasana uudelleen</label>
			<div class="col-sm-10">
				<input type="password" name="passwordconfirm" class="form-control" id="salasana-uudelleen" placeholder="Salasana uudelleen">
			</div>
		  </div>
		  <div class="form-group">
			<label for="kokonimi" class="col-sm-2 control-label">Koko nimi</label>
			<div class="col-sm-10">
				<input type="text" name="fullname" class="form-control" id="kokonimi" placeholder="Etunimi Sukunimi" value="<?=$data->user->getFullName()?>" required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="email" class="col-sm-2 control-label">Sähköposti</label>
			<div class="col-sm-10">
				<input type="email" name="email" class="form-control" id="email" placeholder="Sähköposti" value="<?=$data->user->getEmail()?>" required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="rooli" class="col-sm-2 control-label">Rooli</label>
			<div class="col-sm-10">
				<select name="role" class="form-control" id="rooli" required>
					<?php foreach($data->roles as $role): ?>
						<?php if($role->getId() == $data->user->getRoleId()): ?>
						<option selected value="<?=$role->getId(); ?>"><?=$role->getName(); ?></option>
						<?php else: ?>
						<option value="<?=$role->getId(); ?>"><?=$role->getName(); ?></option>
						<?php endif; ?>
					<?php endforeach; ?>
				</select>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Tallenna</button>
			</div>
		  </div>
		</form>
	</div>
</div>
