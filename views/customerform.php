<div class="row">
	<div class="col-lg-offset-2 col-lg-10">
	  <h2>
		<?php if($data->edit): ?>
		Muokkaa
		<?php else: ?>
		Uusi asiakas
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
		<form method="post" class="form-horizontal" role="form">
		  <div class="form-group">
			<label for="yritys" class="col-sm-2 control-label">Yritys</label>
			<div class="col-sm-10">
				<input type="text" name="yritys" class="form-control" id="yritys" placeholder="Yrityksen nimi" value="<?=$data->customer->getName()?>" required autofocus>
			</div>
		  </div>
		  <div class="form-group">
			<label for="business_id" class="col-sm-2 control-label">Y-tunnus</label>
			<div class="col-sm-10">
				<input type="text" name="business_id" class="form-control" id="business_id" placeholder="Y-tunnus" value="<?=$data->customer->getBusinessId()?>"  required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="email" class="col-sm-2 control-label">Sähköposti</label>
			<div class="col-sm-10">
				<input type="email" name="email" class="form-control" id="email" placeholder="Sähköposti" value="<?=$data->customer->getEmail()?>" required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="puhelin" class="col-sm-2 control-label">Puhelin</label>
			<div class="col-sm-10">
				<input type="phone" name="phone" class="form-control" id="phone" placeholder="Puhelinnumero" value="<?=$data->customer->getPhone()?>" required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="prioriteetti" class="col-sm-2 control-label">Prioriteetti</label>
			<div class="col-sm-10">
				<select name="priority" class="form-control" id="prioriteetti" required>
					<?php foreach($data->priorities as $priority): ?>
						<?php if($priority->getId() == $data->customer->getPriorityId()): ?>
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
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Tallenna</button>
			</div>
		  </div>
		</form>
	</div>
</div>
