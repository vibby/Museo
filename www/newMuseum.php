<?php

require ("../autoload.php");

$controller = new Museo\Controller\MuseumController();
$data = $controller->newAction();
extract($data);

?>

<?php require ("includes/header.php"); ?>

<div class="row">
	<div class="large-12 columns">

		<form action="createMuseum.php" method="POST">
		  <fieldset>
			<legend>Nouveau Musée</legend>
				<?php require ("includes/museumForm.php"); ?>
		  </fieldset>
		</form>

	</div>
</div>

<?php require ("includes/footer.php"); ?>

