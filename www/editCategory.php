<?php

require ("../autoload.php");

$controller = new Museo\Controller\CategoryController();
$data = $controller->editAction();
extract($data);

?>

<?php require ("includes/header.php"); ?>

<div class="row">
	<div class="large-12 columns">

		<form action="modifyCategory.php" method="POST">
			<fieldset>
				<legend>Edition de la catégorie</legend>
				<input type="hidden" name="id" value="<?php echo $values['id'] ?>" />
				<input type="hidden" name="category[id]" value="<?php echo $values['id'] ?>" />
				<?php require ("includes/categoryForm.php"); ?>
			</fieldset>
		</form>

	</div>
</div>

<?php require ("includes/footer.php"); ?>
