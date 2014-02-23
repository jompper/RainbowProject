<div class="row">
	<div class="col-lg-offset-2 col-lg-10">
	  <h2>
		Uusi tuntimerkintä
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
		<form action="<?=URL?>user-task-hours/" method="post" class="form-horizontal" role="form">
		  <div class="form-group">
			<label for="kuvaus" class="col-sm-2 control-label">Kuvaus</label>
			<div class="col-sm-10">
				<textarea name="kuvaus" class="form-control" id="kuvaus" placeholder="Kuvaus" required><?=$data->hour->getDescription()?></textarea>
			</div>
		  </div>
		  <div class="form-group">
			<label for="aloitusaika" class="col-sm-2 control-label">Aloitusaika</label>
			<div class="col-sm-10">
				<input type="datetime-local" name="aloitusaika" class="form-control" id="aloitusaika" placeholder="Aloitusaika" value="<?=$data->hour->getStartTime("Y-m-d\TH:i:00")?>" required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="lopetusaika" class="col-sm-2 control-label">Lopetusaika</label>
			<div class="col-sm-10">
				<input type="datetime-local" name="lopetusaika" class="form-control" id="lopetusaika" placeholder="Lopetusaika" value="<?=$data->hour->getEndTime("Y-m-d\TH:i:00")?>" required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="tehtava" class="col-sm-2 control-label">Tehtävä</label>
			<div class="col-sm-10">
				<select name="tehtava" class="form-control" id="tehtava" required>
					<?php foreach($data->tasks as $task): ?>
						<?php if($task->getId() == $data->hour->getTaskId()): ?>
							<option selected value="<?=$task->getId(); ?>">
						<?php else: ?>
							<option value="<?=$task->getId(); ?>">
						<?php endif; ?>
								<?= $task->getProject()->getName()?> - <?=$task->getName(); ?>
							</option>
					<?php endforeach; ?>
				</select>
			</div>
		  </div>
		  <div class="form-group">
			<label for="kayttaja" class="col-sm-2 control-label">Käyttäjä</label>
			<div class="col-sm-10">
				<select name="kayttaja" class="form-control" id="kayttaja" required>
					<?php foreach($data->users as $user): ?>
						<?php if($user->getId() == $data->hour->getUserId()): ?>
							<option selected value="<?=$user->getId(); ?>">
						<?php else: ?>
							<option value="<?=$user->getId(); ?>">
						<?php endif; ?>
								<?=$user->getFullName(); ?>
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
