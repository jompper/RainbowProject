<div class="row">
	<div class="col-lg-12">
	  <h2>Asiakkaat</h2>
	  <div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-condensed">
		  <thead>
			<tr>
			  <th>Yritys</th>
			  <th>Y-tunnus</th>
			  <th>Sähköposti</th>
			  <th>Puhelin</th>
			  <th>Prioriteetti</th>
			  <th></th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach($data->customers as $customer): ?>
			<tr>
			  <td><?= $customer->getName(); ?></td>
			  <td><?= $customer->getBusinessId(); ?></td>
			  <td><?= $customer->getEmail(); ?></td>
			  <td><?= $customer->getPhone(); ?></td>				  
			  <td><?= $customer->getPriority()->getName(); ?></td>				  
			  <td>
				<a class="btn btn-success" href="<?=URL?>customer/show/?id=<?= $customer->getId(); ?>">Avaa</a>
				<a class="btn btn-warning" href="<?=URL?>customer/edit/?id=<?= $customer->getId(); ?>">Muokkaa</a>
				<a class="btn btn-danger" href="<?=URL?>customer/delete/?id=<?= $customer->getId(); ?>" onclick="return confirm('Haluatko varmasti poistaa asiakkaan <?=$customer->getName()?>?')">Poista</a>
			  </td>
			</tr>
			<?php endforeach; ?>
		  </tbody>
		</table>
		<a href="<?=URL?>customer/create/" class="btn btn-info">Uusi asiakas</a>
	  </div>
	</div>
</div>
