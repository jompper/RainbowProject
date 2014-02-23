<div class="row">
	<div class="col-lg-12">
	  <h2>Tehtävät</h2>
	  <div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-condensed">
		  <thead>
			<tr>
			  <th>Nimi</th>
			  <th>Kuvaus</th>
			  <th>Projekti</th>
			  <th>Määräaika</th>
			  <th>Tuntiarvio</th>
			  <th>Tila</th>
			  <th>Prioriteetti</th>
			  <th></th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach($data->tasks as $task): ?>
			<tr>
			  <td><?= $task->getName(); ?></td>
			  <td><?= $task->getDescription(); ?></td>
			  <td><?= $task->getProject()->getName(); ?></td>
			  <td><?= $task->getDueDate(); ?></td>				  
			  <td><?= $task->getHourEstimate(); ?></td>				  
			  <td><?= $task->getStatus()->getName(); ?></td>				  
			  <td><?= $task->getPriority()->getName(); ?></td>				  
			  <td>
				<a class="btn btn-success" href="<?=URL?>tasks/<?= $task->getId(); ?>/show">Avaa</a>
				<a class="btn btn-warning" href="<?=URL?>tasks/<?= $task->getId(); ?>/edit">Muokkaa</a>
				<?php if($_SESSION['admin']): ?>
				<a class="btn btn-danger" href="<?=URL?>tasks/<?= $task->getId(); ?>/delete" onclick="return confirm('Haluatko varmasti poistaa asiakkaan <?=$task->getName()?>?')">Poista</a>
				<?php endif; ?>
			  </td>
			</tr>
			<?php endforeach; ?>
		  </tbody>
		</table>
		<a href="<?=URL?>tasks/new" class="btn btn-info">Uusi tehtävä</a>
	  </div>
	</div>
</div>
