<div class="row">
	<div class="col-lg-12">
	  <h2>Työtunnit</h2>
	  <div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-condensed">
		  <thead>
			<tr>
			  <th>Asiakas</th>
			  <th>Projekti</th>
			  <th>Tehtävä</th>
			  <th>Käyttäjä</th>
			  <th>Kuvaus</th>
			  <th>Aloitusaika</th>
			  <th>Lopetusaika</th>
			  <th>Toiminnot</th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach($data->hours as $hour): ?>
			<tr>
			  <td><a href="<?=URL?>customers/<?=$hour->getTask()->getProject()->getCustomer()->getId()?>"><?= $hour->getTask()->getProject()->getCustomer()->getName(); ?></td>
			  <td><a href="<?=URL?>projects/<?=$hour->getTask()->getProject()->getId()?>"><?= $hour->getTask()->getProject()->getName(); ?></td>
			  <td><a href="<?=URL?>tasks/<?=$hour->getTask()->getId()?>"><?= $hour->getTask()->getName(); ?></td>
			  <td><?= $hour->getUser()->getFullName(); ?></td>
			  <td><?= $hour->getDescription() ?></td>
			  <td><?= $hour->getStartTime(); ?></td>			  
			  <td><?= $hour->getEndTime(); ?></td>		  
			  <td>
				<a class="btn btn-danger" href="<?=URL?>user-task-hours/<?= $hour->getId(); ?>/delete" onclick="return confirm('Haluatko varmasti poistaa suoritetut työtunnit?')">Poista</a>
			  </td>
			</tr>
			<?php endforeach; ?>
		  </tbody>
		</table>
		<a href="<?=URL?>user-task-hours/new" class="btn btn-info">Lisää merkintä</a>
	  </div>
	</div>
</div>
