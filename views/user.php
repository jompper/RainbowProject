<div class="row">
	<div class="col-lg-12">
	  <h2>Tehtäväluettelo - <?=$data->user->getFullName()?></h2>
	</div>
</div>
<hr/>

<div class="row">
	<div class="col-lg-8">
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
	</div>
	<div class="col-lg-4">
		<strong>Nimi:</strong> <?=$data->user->getFullName()?><br/>
		<strong>Käyttäjätunnus:</strong> <?=$data->user->getUsername()?><br>
		<strong>Sähköposti:</strong> <?=$data->user->getEmail()?><br>		
		<strong>Rooli:</strong> <?=$data->user->getRole()->getName()?><br>		
	</div>
</div>

<hr/>

<div class="row">
	<div class="col-lg-12">
	  
	</div>
</div>
