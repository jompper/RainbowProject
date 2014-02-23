<div class="row">
	<div class="col-lg-12">
	  <h2>Käyttäjät</h2>
	  <div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-condensed">
		  <thead>
			<tr>
			  <th>Käyttäjätunnus</th>
			  <th>Nimi</th>
			  <th>Sähköposti</th>
			  <th>Rooli</th>
			  <th colspan="2">Toiminnot</th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach($data->users as $user): ?>
			<tr>
			  <td><a href="<?=URL?>users/<?= $user->getId()?>/show"><?= $user->getUsername(); ?></a></td>
			  <td><?= $user->getFullName(); ?></td>
			  <td><?= $user->getEmail(); ?></td>
			  <td><?= $user->isAdmin()?"Ylläpitäjä":"Tavallinen"; ?></td>				  
			  <td>
				<a class="btn btn-warning" href="<?=URL?>users/<?= $user->getId()?>/edit">Muokkaa</a>
			  </td>
			  <td>
				<a class="btn btn-danger" href="<?=URL?>users/<?= $user->getId()?>/delete" onclick="return confirm('Haluatko varmasti poistaa käyttäjän <?=$user->getUsername()?>?')">Poista</a>
			  </td>
			</tr>
			<?php endforeach; ?>
		  </tbody>
		</table>
		<?php if($_SESSION['admin']): ?>
		<a href="<?=URL?>users/new" class="btn btn-info">Uusi käyttäjä</a>
		<?php endif; ?>
	  </div>
	</div>
</div>
