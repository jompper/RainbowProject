	  <?php if(count($data->tasks)): ?>
      <div class="row">
        <div class="col-lg-12">
          <h2>Tehtäväluettelo</h2>
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
			<?php foreach($data->tasks as $task): ?>
			<tr>
			  <td>
				<a href="<?=URL?>tasks/<?=$task->getId()?>">
					<?=$task->getName()?>
				</a>
			  </td>
			  <td>
				<a href="<?=URL?>projects/<?=$task->getProject()->getId()?>">
					<?=$task->getProject()->getName()?>
				</a>
			  </td>
			  <td>
				<a href="<?=URL?>customers/<?=$task->getProject()->getCustomer()->getId()?>">
				  <?=$task->getProject()->getCustomer()->getName()?>
				</a>
			  </td>
			  
			  <td><?=$task->getHourEstimate()?></td>
			  <td><?=$task->getDueDate()?></td>
			  <td>
				<a class="btn btn-warning" href="<?=URL?>user-task-hours/<?=$task->getId()?>/new">Merkintä</a>
			  </td>
			</tr>
			<?php endforeach; ?>
		  </tbody>
		</table>
		  </div>
        </div>
      </div>
	  <?php else: ?>
	  <div class="row">
        <div class="col-lg-12">
			<p>Sinulla ei ole tehtäviä.</p>
		</div>
	  </div>
	  <?php endif; ?>
