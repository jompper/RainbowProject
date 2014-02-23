<div class="row">
	<div class="col-lg-offset-2 col-lg-10">
	  <h2>
		<?php if($data->edit): ?>
		Muokkaa
		<?php else: ?>
		Uusi projekti
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
		<form action="<?=URL?>projects/<? if($data->edit)echo $data->project->getId();?>" method="post" class="form-horizontal" role="form">
		  <div class="form-group">
			<label for="nimi" class="col-sm-2 control-label">Nimi</label>
			<div class="col-sm-10">
				<input type="text" name="nimi" class="form-control" id="nimi" placeholder="Projektin nimi" value="<?=$data->project->getName()?>" required autofocus>
			</div>
		  </div>
		  <div class="form-group">
			<label for="kuvaus" class="col-sm-2 control-label">Kuvaus</label>
			<div class="col-sm-10">
				<textarea name="kuvaus" class="form-control" id="kuvaus" placeholder="Projektin kuvaus"><?=$data->project->getDescription()?></textarea>
			</div>
		  </div>
		  <div class="form-group">
			<label for="maara_aika" class="col-sm-2 control-label">Määräaika</label>
			<div class="col-sm-10">
				<input type="date" name="maara_aika" class="form-control" id="maara_aika" placeholder="Määräaika" value="<?=$data->project->getDueDate("Y-m-d")?>" required>
			</div>
		  </div>
		  <?php if(!$data->edit): ?>
		  <div class="form-group">
			<label for="asiakas" class="col-sm-2 control-label">Asiakas</label>
			<div class="col-sm-10">
				<select name="asiakas" class="form-control" id="asiakas" required>
					<?php foreach($data->customers as $customer): ?>
						<?php if($customer->getId() == $data->project->getCustomerId()): ?>
							<option selected value="<?=$customer->getId(); ?>">
						<?php else: ?>
							<option value="<?=$customer->getId(); ?>">
						<?php endif; ?>
								<?=$customer->getName(); ?>
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
						<?php if($priority->getId() == $data->project->getPriorityId()): ?>
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
						<?php if($status->getId() == $data->project->getStatusId()): ?>
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
