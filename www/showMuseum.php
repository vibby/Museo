<?php

require ("../autoload.php");

$controller = new Museo\Controller\MuseumController();
$data = $controller->showAction();
extract($data);

?>

<?php require ("includes/header.php"); ?>

<div class="row">
	<div class="large-12 columns ">
		<ul class="button-group round right">
			<li><a class="button " href="editMuseum.php?id=<?php echo $museum->getId() ?>">Editer</a></li>
			<li><a class="button alert" href="deleteMuseum.php?id=<?php echo $museum->getId() ?>">Supprimer</a></li>
		</ul>
		<h1><?php echo $museum->getName() ?></h1>
		<?php foreach ($museum->getCategories() as $category) : ?>
			<span class="label"><?php echo $category->getName() ?></span>
		<?php endforeach; ?><br /><br />
		<div class="panel">
			<?php if ($museum->getDescription()) : ?>
				<?php echo $museum->getDescription() ?>
			<?php else : ?>
				<em>Aucune description pour ce musée</em>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php require ("includes/footer.php"); ?>
