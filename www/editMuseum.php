<?php

require ("../autoload.php");

$controller = new Museo\Controller\MuseumController();
$data = $controller->editAction();
extract($data);

?>

<?php require ("includes/header.php"); ?>

<div class="row">
	<div class="large-12 columns">

		<form action="modifyMuseum.php" method="POST">
			<fieldset>
				<legend>Edition du Musée</legend>
				<input type="hidden" name="id" value="<?php echo $values['id'] ?>" />
				<input type="hidden" name="museum[id]" value="<?php echo $values['id'] ?>" />
				<?php require ("includes/museumForm.php"); ?>
			</fieldset>
		</form>

	</div>
</div>

<?php require ("includes/footer.php"); ?>
