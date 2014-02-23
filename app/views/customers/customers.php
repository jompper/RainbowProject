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
			  <?php if($_SESSION['admin']): ?>
			  <th colspan="2">Toiminnot</th>
			  <?php else: ?>
			  <th>Toiminnot</th>
			  <?php endif; ?>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach($data->customers as $customer): ?>
			<tr>
			  <td><a href="<?=URL?>customers/<?= $customer->getId(); ?>/show"><?= $customer->getName(); ?></a></td>
			  <td><?= $customer->getBusinessId(); ?></td>
			  <td><?= $customer->getEmail(); ?></td>
			  <td><?= $customer->getPhone(); ?></td>				  
			  <td><?= $customer->getPriority()->getName(); ?></td>				  
			  <td>
				<a class="btn btn-warning" href="<?=URL?>customers/<?= $customer->getId(); ?>/edit">Muokkaa</a>
			  </td>
			  
			  <?php if($_SESSION['admin']): ?>
			  <td>
				<a class="btn btn-danger" href="<?=URL?>customers/<?= $customer->getId(); ?>/delete" onclick="return confirm('Haluatko varmasti poistaa asiakkaan <?=$customer->getName()?>?')">Poista</a>
			  </td>
			  <?php endif; ?>
			  
			</tr>
			<?php endforeach; ?>
		  </tbody>
		</table>
		<a href="<?=URL?>customers/new" class="btn btn-info">Uusi asiakas</a>
	  </div>
	</div>
</div>
