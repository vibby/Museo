<?php

require ("../autoload.php");

$controller = new Museo\Controller\CategoryController();
$data = $controller->newAction();
extract($data);

?>

<?php require ("includes/header.php"); ?>

<div class="row">
	<div class="large-12 columns">

		<form action="createCategory.php" method="POST">
		  <fieldset>
			<legend>Nouvelle catégorie</legend>
				<?php require ("includes/categoryForm.php"); ?>
		  </fieldset>
		</form>

	</div>
</div>

<?php require ("includes/footer.php"); ?>

