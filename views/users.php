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
			  <th>Toiminnot</th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach($data->users as $user): ?>
			<tr>
			  <td><?= $user->getUsername(); ?></td>
			  <td><?= $user->getFullName(); ?></td>
			  <td><?= $user->getEmail(); ?></td>
			  <td><?= $user->getRole()->getName(); ?></td>				  
			  <td>
				<a class="btn btn-success" href="<?=URL?>user/show/?id=<?= $user->getId(); ?>">Avaa</a>
				<a class="btn btn-warning" href="<?=URL?>user/edit/?id=<?= $user->getId(); ?>">Muokkaa</a>
				<a class="btn btn-danger" href="<?=URL?>user/delete/?id=<?= $user->getId(); ?>" onclick="return confirm('Haluatko varmasti poistaa käyttäjän <?=$user->getUsername()?>?')">Poista</a>
			  </td>
			</tr>
			<?php endforeach; ?>
		  </tbody>
		</table>
		<a href="<?=URL?>user/create/" class="btn btn-info">Uusi käyttäjä</a>
	  </div>
	</div>
</div>
