 <!-- Jumbotron -->
      <div class="jumbotron">
        <h1>Tervetuloa <?=$data->user->getUsername()?>!</h1>
        <p class="lead">Sinulla on <?=count($data->tasks)?> tehtävää, joista 0 on kiireellisiä.</p>
      </div>
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
			  <td><?=$task->getName()?></td>
			  <td></td>
			  <td></td>
			  <td><?=$task->getHourEstimate()?></td>
			  <td><?=$task->getDueDate()?></td>
			  <td>
				<a class="btn btn-success" href="#">Avaa</a>
				<a class="btn btn-warning" href="#">Merkintä</a>
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
			Sinulla ei ole tehtäviä.
		</div>
	  </div>
	  <?php endif; ?>
