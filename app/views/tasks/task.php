<div class="row">
	<div class="col-lg-12">
	  <h2>
		<a href="<?=URL?>projects/<?=$data->task->getProject()->getId()?>">
			<?=$data->task->getProject()->getName() ?>
		</a> - <?=$data->task->getName()?></h2>
	</div>
</div>
<hr/>
<div class="row">
	<div class="col-lg-6">
		<div class="row">
			<div class="col-lg-2">
				<p><strong>Kuvaus</strong></p>
			</div>
			<div class="col-lg-10">
				<p><?=$data->task->getDescription(); ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-2">
				<p><strong>Määräaika</strong></p>
			</div>
			<div class="col-lg-10">
				<p><?=$data->task->getDueDate(); ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-2">
				<p><strong>Tuntiarvio</strong></p>
			</div>
			<div class="col-lg-10">
				<p><?=$data->task->getHourEstimate(); ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-2">
				<p><strong>Tila</strong></p>
			</div>
			<div class="col-lg-10">
				<p><?=$data->task->getStatus()->getName(); ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-2">
				<p><strong>Prioriteetti</strong></p>
			</div>
			<div class="col-lg-10">
				<p><?=$data->task->getPriority()->getName(); ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-2">
				<p><strong>Käyttäjät</strong></p>
			</div>
			<div class="col-lg-8">
				<ul class="list-group">
					<?php foreach($data->users as $user): ?>
					<li class="list-group-item"><?= $user->getFullName(); ?>
						<a href="<?=URL?>user-tasks/delete/?userId=<?=$user->getId()?>&taskId=<?=$data->task->getId()?>" class="glyphicon glyphicon-remove pull-right"></a>
					</li>
					<?php endforeach; ?>
				</ul>
				<a href="<?=URL?>user-tasks/<?=$data->task->getId()?>/new" class="btn btn-info">Lisää</a>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover table-condensed">
				<thead>
					<tr>
					  <th>Käyttäjä</th>
					  <th>Kuvaus</th>
					  <th>Alku</th>
					  <th>Loppu</th>
					  <th>Toiminnot</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($data->hours as $hour): ?>
						<tr>
							<td><?=$hour->getUser()->getFullName()?></td>
							<td><?=$hour->getDescription()?></td>
							<td><?=$hour->getStartTime("H:i")?></td>
							<td><?=$hour->getEndTime("H:i")?></td>
							<td><a class="btn btn-danger" href="<?=URL?>user-task-hours/<?=$hour->getId()?>/delete">Poista</a></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</diV>
		<a href="<?=URL?>user-task-hours/<?=$data->task->getId()?>/new" class="btn btn-info">Lisää</a>
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
		<form action="<?=URL?>tasks/<?=$data->task->getId()?>/comment" method="post" role="form">
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
