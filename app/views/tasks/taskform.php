<div class="row">
	<div class="col-lg-offset-2 col-lg-10">
	  <h2>
		<?php if($data->edit): ?>
		Muokkaa
		<?php else: ?>
		Uusi tehtävä
		<?php endif; ?>
	  </h2>
	</div>
</div>
<?php if(!empty($data->errors)): ?>
	<div class="alert alert-danger col-lg-offset-2 col-lg-10">
		<ul>
		<?php foreach($data->errors as $error): ?>
			<li><?=$error?></li>	
		<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>
<div class="row">
	<div class="col-lg-12">	
		<form action="<?=URL?>tasks/<? if($data->edit)echo $data->task->getId();?>" method="post" class="form-horizontal" role="form">
		  <div class="form-group">
			<label for="nimi" class="col-sm-2 control-label">Nimi</label>
			<div class="col-sm-10">
				<input type="text" name="nimi" class="form-control" id="nimi" placeholder="Tehävän nimi" value="<?=$data->task->getName()?>" required autofocus>
			</div>
		  </div>
		  <div class="form-group">
			<label for="kuvaus" class="col-sm-2 control-label">Kuvaus</label>
			<div class="col-sm-10">
				<textarea name="kuvaus" class="form-control" id="kuvaus" placeholder="Tehtävän kuvaus"><?=$data->task->getDescription()?></textarea>
			</div>
		  </div>
		  <div class="form-group">
			<label for="maara_aika" class="col-sm-2 control-label">Määräaika</label>
			<div class="col-sm-10">
				<input type="date" name="maara_aika" class="form-control" id="maara_aika" placeholder="Määräaika" value="<?=$data->task->getDueDate("Y-m-d")?>" required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="tuntiarvio" class="col-sm-2 control-label">Tuntiarvio</label>
			<div class="col-sm-10">
				<input type="number" name="tuntiarvio" class="form-control" id="tuntiarvio" placeholder="Tuntiarvio" value="<?=$data->task->getHourEstimate()?>"  min="1" required>
			</div>
		  </div>
		  <?php if(!$data->edit): ?>
		  <div class="form-group">
			<label for="projekti" class="col-sm-2 control-label">Projekti</label>
			<div class="col-sm-10">
				<select name="projekti" class="form-control" id="projekti" required>
					<?php foreach($data->projects as $project): ?>
						<?php if($project->getId() == $data->task->getProjectId()): ?>
							<option selected value="<?=$project->getId(); ?>">
						<?php else: ?>
							<option value="<?=$project->getId(); ?>">
						<?php endif; ?>
								<?=$project->getName(); ?>
							</option>
					<?php endforeach; ?>
				</select>
			</div>
		  </div>
		  <?php endif; ?>
		  <div class="form-group">
			<label for="prioriteetti" class="col-sm-2 control-label">Prioriteetti</label>
			<div class="col-sm-10">
				<select name="prioriteetti" class="form-control" id="prioriteetti" required>
					<?php foreach($data->priorities as $priority): ?>
						<?php if($priority->getId() == $data->task->getPriorityId()): ?>
							<option selected value="<?=$priority->getId(); ?>">
						<?php else: ?>
							<option value="<?=$priority->getId(); ?>">
						<?php endif; ?>
								<?=$priority->getName(); ?>
								(<?=$priority->getValue();?>)
							</option>
						
					<?php endforeach; ?>
				</select>
			</div>
		  </div>
		  <div class="form-group">
			<label for="tila" class="col-sm-2 control-label">Tila</label>
			<div class="col-sm-10">
				<select name="tila" class="form-control" id="tila" required>
					<?php foreach($data->statuses as $status): ?>
						<?php if($status->getId() == $data->task->getStatusId()): ?>
							<option selected value="<?=$status->getId(); ?>">
						<?php else: ?>
							<option value="<?=$status->getId(); ?>">
						<?php endif; ?>
								<?=$status->getName(); ?>
							</option>
					<?php endforeach; ?>
				</select>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Tallenna</button>
			</div>
		  </div>
		</form>
	</div>
</div>
