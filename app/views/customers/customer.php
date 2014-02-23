<div class="row">
	<div class="col-lg-12">
	  <h2>Projektiluettelo - <?=$data->customer->getName()?></h2>
	</div>
</div>
<hr/>
<div class="row">
	<div class="col-lg-8">
	  <?php if(count($data->projects)): ?>
	  <div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-condensed">
		  <thead>
			<tr>
			  <th>Projekti</th>
			  <th>Kuvaus</th>
			  <th>Määräaika</th>
			  <th colspan="2">Toiminnot</th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach($data->projects as $project): ?>
			<tr>
			  <td><a href="<?=URL?>projects/<?=$project->getId()?>"><?=$project->getName()?></a></td>
			  <td>
				<?php if(strlen($project->getDescription())>50): ?>
					<?= substr($project->getDescription(),0,50); ?>...
				<?php else: ?>
					<?= $project->getDescription() ?>
				<?php endif; ?>
			  </td>
			  <td><?=$project->getDueDate()?></td>
			  <td>
				<a class="btn btn-warning" href="<?=URL?>projects/<?=$project->getId()?>/edit">Muokkaa</a>
			  </td>
			  <td>
				<a class="btn btn-danger" href="<?=URL?>projects/<?=$project->getId()?>/delete">Poista</a>
			  </td>
			</tr>
			<?php endforeach; ?>
		  </tbody>
		</table>
	  </div>
	  <?php else: ?>
		<p>Ei projekteja</p>
	  <?php endif; ?>
	  <a href="<?=URL?>projects/<?=$data->customer->getId()?>/new" class="btn btn-info">Uusi projekti</a>
	</div>
	<div class="col-lg-4">
		<div class="row">
			<div class="col-lg-4">
				<p><strong>Nimi</strong></p>
			</div>
			<div class="col-lg-8">
				<p><?=$data->customer->getName()?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<p><strong>Y-tunnus</strong></p>
			</div>
			<div class="col-lg-8">
				<p><?=$data->customer->getBusinessId()?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<p><strong>Puhelin</strong></p>
			</div>
			<div class="col-lg-8">
				<p><?=$data->customer->getPhone()?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<p><strong>Sähköposti</strong></p>
			</div>
			<div class="col-lg-8">
				<p><?=$data->customer->getEmail()?></p>
			</div>
		</div>
		<a href="<?=URL?>project/<?=$data->project->getId()?>/edit/">Muokkaa</a>
	</div>
</div>

<hr/>
