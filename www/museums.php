<?php

require ("../autoload.php");

$controller = new Museo\Controller\MuseumController();
$data = $controller->listAction();
extract($data);

?>

<?php require ("includes/header.php"); ?>



<ul class="no-bullet museums-list">
<?php $i = 1; ?>
<?php foreach ($collection as $museum) : ?>
	<?php $i++; ?>
	<li class="<?php if(!($i % 2)) : ?> odd<?php endif; ?>" >
		<div class="row">
		<div class="large-12 columns">
		<h3 class="left">
			<a href="showMuseum.php?id=<?php echo $museum->getId() ?>"><?php echo $museum->getName() ?></a>
		</h3>
		<ul class="button-group round ">
			<li><a class="button tiny " href="showMuseum.php?id=<?php echo $museum->getId() ?>">Voir</a></li>
			<li><a class="button tiny " href="editMuseum.php?id=<?php echo $museum->getId() ?>">Éditer</a></li>
			<li><a class="button alert tiny" href="deleteMuseum.php?id=<?php echo $museum->getId() ?>">&#x2715;	</a></li>
		</ul>
		<div style="clear:left;">
		<?php foreach ($museum->getCategories() as $category) : ?>
			<span class="radius label secondary"><?php echo $category->getName() ?></span>
		<?php endforeach; ?>
		</div>
		<br />
		</div>
		</div>
	</li>
<?php endforeach; ?>
</ul>


<?php require ("includes/footer.php"); ?>
