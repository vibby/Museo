<?php

require ("../autoload.php");

$controller = new Museo\Controller\CategoryController();
$data = $controller->listAction();
extract($data);
?>

<?php require ("includes/header.php"); ?>

<div class="row">
	<div class="large-12 columns ">
	<h3>Catégorisation</h3>
	<div class="panel categories">

<?php function showTree($collection) { ?>
	<ul class="disc">
		<?php foreach ($collection as $category) : ?>
		<li>
			<span class="label "><?php echo $category->getName() ?> </span><a class="button success tiny " href="editCategory.php?id=<?php echo $category->getId() ?>">&nbsp;&#x270E;&nbsp;</a><a class="button alert tiny" href="deleteCategory.php?id=<?php echo $category->getId() ?>">&#x2715;</a>


			<?php if (!is_null($category->getChildren())) : ?>
				<?php showTree($category->getChildren()); ?>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
	</ul>
<?php } ?>

<?php showTree($collection); ?>

	</div>
	</div>
</div>

<?php require ("includes/footer.php"); ?>
