<?php

require ("../autoload.php");

$controller = new Museo\Controller\MuseumController();
$data = $controller->deleteAction();
extract($data);

?>

<?php require ("includes/header.php"); ?>

<div class="row">
	<div class="large-12 columns">

		<div class="panel radius">
			Vous êtes sur le point de supprimer le Musée "<em><?php echo $museum->getName(); ?></em>", en êtes-vous sûr ?
			<div class="right">
				<a class="button alert right" href="eraseMuseum.php?id=<?php echo $museum->getId() ?>">Confirmer la suppression</a>
				<a class="button secondary right" href="museums.php">Annuler</a>
			</div>
			<hr />
		</div>

	</div>
</div>

<?php require ("includes/footer.php"); ?>
