<div class="row">
	<div class="col-lg-12">
	  <h2>Tehtäväluettelo - <?=$data->project->getName()?></h2>
	</div>
</div>
<hr/>
<div class="row">
	<div class="col-lg-8">
	  <?php if(count($data->tasks)): ?>
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
			<?php foreach($data->tasks as $task): ?>
			<tr>
			  <td><?=$task->getName()?></td>
			  <td></td>
			  <td></td>
			  <td><?=$task->getHourEstimate()?></td>
			  <td><?=$task->getDueDate()?></td>
			  <td>
				<a class="btn btn-success" href="#">Avaa</a>
				<a class="btn btn-warning" href="#">Merkintä</a>
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
		<strong>Nimi:</strong> <?=$data->project->getName()?><br/>
		<strong>Kuvaus:</strong><br/><?= nl2br($data->project->getDescription())?><br>
		<strong>Määräaika:</strong> <?=$data->project->getDueDate()?><br>		
	</div>
</div>

<hr/>
