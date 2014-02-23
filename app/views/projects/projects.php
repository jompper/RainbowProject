<div class="row">
	<div class="col-lg-12">
	  <h2>Projektit</h2>
	  <div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-condensed">
		  <thead>
			<tr>
			  <th>Asiakas</th>
			  <th>Projekti</th>
			  <th>Kuvaus</th>
			  <th>Määräaika</th>
			  <th>Prioriteetti</th>
			  <th>Tila</th>
			  <th colspan="2">Toiminnot</th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach($data->projects as $project): ?>
			<tr>
			  <td><a href="<?=URL?>customers/<?= $project->getCustomer()->getId(); ?>"><?= $project->getCustomer()->getName(); ?></a></td>	
			  <td><a href="<?=URL?>projects/<?= $project->getId(); ?>"><?= $project->getName(); ?></a></td>
			  <td>
				<?php if(strlen($project->getDescription())>50): ?>
					<?= substr($project->getDescription(),0,50); ?>...
				<?php else: ?>
					<?= $project->getDescription() ?>
				<?php endif; ?>
			  </td>
			  <td><?= $project->getDueDate(); ?></td>			  
			  		  
			  <td><?= $project->getPriority()->getName(); ?></td>			  
			  <td><?= $project->getStatus()->getName(); ?></td>			  
			  <td>
				<a class="btn btn-warning" href="<?=URL?>projects/<?= $project->getId(); ?>/edit">Muokkaa</a>
			  </td>
			  <td>
				<a class="btn btn-danger" href="<?=URL?>projects/<?= $project->getId(); ?>/delete" onclick="return confirm('Haluatko varmasti poistaa projektin <?=$project->getName()?>?')">Poista</a>
			  </td>
			</tr>
			<?php endforeach; ?>
		  </tbody>
		</table>
		<a href="<?=URL?>projects/new" class="btn btn-info">Uusi projekti</a>
	  </div>
	</div>
</div>
