<?php

require ("../autoload.php");

$controller = new Museo\Controller\CategoryController();
$data = $controller->deleteAction();
extract($data);

?>

<?php require ("includes/header.php"); ?>

<div class="row">
	<div class="large-12 columns">

		<div class="panel radius">
			<form method="POST" action="eraseCategory.php" ?>
				<input type="hidden" name="id" value="<?php echo $category->getId() ?>" />
				<p>Vous êtes sur le point de supprimer la Catégorie <span class="label"><?php echo $category->getName(); ?></span>, en êtes-vous sûr ?</p>
				<?php if ($category->getChildren()): ?>
					<p>
						Cette catégorie contient les sous-catégories
							<?php $i=0; foreach ($category->getChildren() as $child): $i++ ?>
								<span class="label"><?php echo $child->getName(); ?></span><?php if (count($category->getChildren()) == $i+1): ?> et
								<?php elseif (count($category->getChildren()) > $i+1): ?>,
								<?php else: ?>.
								<?php endif; ?>
							<?php endforeach; ?>
							Que souhaitez-vous faire de ces catégories ?
						<div class="row">
							<div class="large-12 columns">
								<label><input type="radio" required name="childrenInherit" value="cascade" /> Supprimer toutes les sous-catégories (y compris les sous-catégories de niveau inférieur)</label>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<label><input type="radio" required name="childrenInherit" value="liftUp" /> Déplacer ces sous-catégories à l'échellon supérieur</label>
							</div>
						</div>
					</p>
				<?php endif; ?>
				<div class="right">
					<button type="submit" class="button alert right" href="eraseCategory.php?id=<?php echo $category->getId() ?>">Confirmer la supression</button>
					<a class="button secondary right" href="categories.php">Annuler</a>
				</div>
			<hr />
			</form>
		</div>

	</div>
</div>

