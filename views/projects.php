<div class="row">
	<div class="col-lg-12">
	  <h2>Projektit</h2>
	  <div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-condensed">
		  <thead>
			<tr>
			  <th>Projekti</th>
			  <th>Kuvaus</th>
			  <th>Määräaika</th>
			  <th>Asiakas</th>
			  <th>Prioriteetti</th>
			  <th>Tila</th>
			  <th colspan="3">Toiminnot</th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach($data->projects as $project): ?>
			<tr>
			  <td><?= $project->getName(); ?></td>
			  <td>
				<?php if(strlen($project->getDescription())>50): ?>
					<?= substr($project->getDescription(),0,50); ?>...
				<?php else: ?>
					<?= $project->getDescription() ?>
				<?php endif; ?>
			  </td>
			  <td><?= $project->getDueDate(); ?></td>			  
			  <td><?= $project->getCustomer()->getName(); ?></td>			  
			  <td><?= $project->getPriority()->getName(); ?></td>			  
			  <td><?= $project->getStatus()->getName(); ?></td>			  
			  <td>
				<a class="btn btn-success" href="<?=URL?>project/show/?id=<?= $project->getId(); ?>">Avaa</a>
			  </td>
			  <td>
				<a class="btn btn-warning" href="<?=URL?>project/edit/?id=<?= $project->getId(); ?>">Muokkaa</a>
			  </td>
			  <td>
				<a class="btn btn-danger" href="<?=URL?>project/delete/?id=<?= $project->getId(); ?>" onclick="return confirm('Haluatko varmasti poistaa projektin <?=$project->getName()?>?')">Poista</a>
			  </td>
			</tr>
			<?php endforeach; ?>
		  </tbody>
		</table>
		<a href="<?=URL?>project/create/" class="btn btn-info">Uusi projekti</a>
	  </div>
	</div>
</div>
