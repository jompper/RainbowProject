<div class="row">
	<div class="col-lg-12">
	  <h2><a href="<?=URL?>customers/<?=$data->project->getCustomer()->getId()?>"><?= $data->project->getCustomer()->getName()?></a> - <?=$data->project->getName()?></h2>
	</div>
</div>
<hr/>
<div class="row">
	<div class="col-lg-12">
	  <?php if(count($data->tasks)): ?>
	  <div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-condensed">
		  <thead>
			<tr>
			  <th>Tehtävä</th>
			  <th>Kuvaus</th>
			  <th>Tuntiarvio</th>
			  <th>Tila</th>
			  <th>Prioriteetti</th>
			  <th>Määräaika</th>
			  <th colspan="2">Toiminnot</th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach($data->tasks as $task): ?>
			<tr>
			  <td><a href="<?=URL?>tasks/<?=$task->getId()?>"><?=$task->getName()?></a></td>
			  <td>
				<?php if(strlen($task->getDescription())>50): ?>
					<?= substr($task->getDescription(),0,50); ?>...
				<?php else: ?>
					<?= $task->getDescription() ?>
				<?php endif; ?>
			  </td>
			  <td><?=$task->getHourEstimate()?></td>
			  <td><?=$task->getDueDate()?></td>
			  <td><?=$task->getStatus()->getName()?></td>
			  <td>
				<a class="btn btn-warning" href="<?=URL?>tasks/<?=$task->getId()?>/edit">Muokkaa</a>
			  </td>
			  <td>
				<a class="btn btn-danger" href="<?=URL?>tasks/<?=$task->getId()?>/delete">Poista</a>
			  </td>
			</tr>
			<?php endforeach; ?>
		  </tbody>
		</table>
	  </div>
	  <?php else: ?>
		<p>Ei tehtäviä</p>
	  <?php endif; ?>
	  <a href="<?=URL?>tasks/<?=$data->project->getId()?>/new" class="btn btn-info">Uusi tehtävä</a>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-lg-7">
		<div class="panel panel-default">
			<div class="panel-body">
				<?php if(count($data->comments)): ?>
					<?php foreach($data->comments as $comment): ?>
					<blockquote>
						<p><?=$comment->getComment()?></p>
						<footer><?=$comment->getUser()->getFullName()?> - <?=$comment->getPostDate("d.m.Y")?></footer>
					</blockquote>
					<?php endforeach; ?>
				<?php else: ?>
					<p>Ei kommentteja</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="col-lg-5">
		<div class="row">
			<div class="col-lg-3">
				<p><strong>Nimi</strong></p>
			</div>
			<div class="col-lg-9">
				<p><?=$data->project->getName()?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3">
				<p><strong>Kuvaus</strong></p>
			</div>
			<div class="col-lg-9">
				<p><?= nl2br($data->project->getDescription())?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3">
				<p><strong>Asiakas</strong></p>
			</div>
			<div class="col-lg-9">
				<a href="<?=URL?>customers/<?=$data->project->getCustomer()->getId()?>"><?= $data->project->getCustomer()->getName()?></a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3">
				<p><strong>Määräaika</strong></p>
			</div>
			<div class="col-lg-9">
				<p><?=$data->project->getDueDate()?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3">
				<p><strong>Tila</strong></p>
			</div>
			<div class="col-lg-9">
				<p><?=$data->project->getStatus()->getName()?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3">
				<p><strong>Prioriteetti</strong></p>
			</div>
			<div class="col-lg-9">
				<p><?=$data->project->getPriority()->getName()?></p>
			</div>
		</div>
		<a href="<?=URL?>projects/<?=$data->project->getId()?>/edit">Muokkaa</a>
		<hr>
		<form action="<?=URL?>projects/<?=$data->project->getId()?>/comment" method="post" role="form">
			<div class="form-group">
				<textarea name="kommentti" rows="3" class="form-control" placeholder="Kommentti" required></textarea>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Kommentoi</button>
			</div>
		</form>
	</div>	
</div>
<hr/>