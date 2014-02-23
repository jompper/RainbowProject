<div class="row">
	<div class="col-lg-12">
	  <h2>Tehtäväluettelo - <?=$data->user->getFullName()?></h2>
	</div>
</div>
<hr/>
<div class="row">
	<div class="col-lg-8">
	  <?php if(count($data->user->getTasks())): ?>
	  <div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-condensed">
		  <thead>
			<tr>
			  <th>Tehtävä</th>
			  <th>Projekti</th>
			  <th>Asiakas</th>
			  <th>Tuntiarvio</th>
			  <th>Määräaika</th>
			  <th>Toiminnot</th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach($data->user->getTasks() as $task): ?>
			<tr>
			  <td>
				<a href="<?=URL?>tasks/<?=$task->getId()?>">
					<?=$task->getName()?>
				</a>
			  </td>
			  <td>
				<a href="<?=URL?>tasks/<?=$task->getProject()->getId()?>">
					<?=$task->getProject()->getName()?>
				</a>
			  </td>
			  <td>
				<a href="<?=URL?>tasks/<?=$task->getProject()->getCustomer()->getId()?>">
					<?=$task->getProject()->getCustomer()->getName()?>
				</a>
			  </td>
			  <td><?=$task->getHourEstimate()?></td>
			  <td><?=$task->getDueDate()?></td>
			  <td>
				<a class="btn btn-warning" href="<?=URL?>user-task-hours/<?=$task->getId()?>/new">Merkintä</a>
			  </td>
			</tr>
			<?php endforeach; ?>
		  </tbody>
		</table>
	  </div>
	  <?php else: ?>
		Ei tehtäviä
	  <?php endif; ?>
	</div>
	<div class="col-lg-4">
		<strong>Nimi:</strong> <?=$data->user->getFullName()?><br/>
		<strong>Käyttäjätunnus:</strong> <?=$data->user->getUsername()?><br>
		<strong>Sähköposti:</strong> <?=$data->user->getEmail()?><br>		
		<strong>Rooli:</strong> <?=$data->user->isAdmin()?"Ylläpitäjä":"Tavallinen" ?><br>		
	</div>
</div>

<hr/>
