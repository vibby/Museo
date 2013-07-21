
<?php $js .= <<<EOF
	<script src="select2-3.4.1/select2.js"></script>
	<script>
		$(document).ready(function() {
			$("#categories").select2({containerCssClass: "large-12 columns"});
		});
	</script>
EOF
	;
?>

   <input type="hidden" name="token" value="<?php echo $token; ?>">
		
    <div class="row">
      <div class="large-12 columns">
		<?php if (array_key_exists('name',$errors)) : ?>
			<label class="error"> 
				<?php foreach ($errors['name'] as $error) : ?>
					<?php echo $error ?><br />
				<?php endforeach; ?>
			</label> 
		<?php endif; ?>
        <input	 class="name <?php if (array_key_exists('name',$errors)) : ?>error<?php endif; ?>" type="text" name="category[name]" placeholder="Nom de la catégorie"
			<?php if (array_key_exists('name',$values)) : ?>
				value="<?php echo $values['name'] ?>"
			<?php endif; ?>
		>
      </div>
    </div>
	
    <div class="row">
      <div class="large-12 columns">
        <label>Catégorie parente</label>
		<?php if (array_key_exists('parentid',$errors)) : ?>
			<label class="error"> 
				<?php foreach ($errors['parentid'] as $error) : ?>
					<?php echo $error ?>
				<?php endforeach; ?>
			</label> 
		<?php endif; ?>
		<select name="category[parentid]" id="categories">
			<option value="0" <?php if (array_key_exists('categories',$values)) : ?>selected<?php endif; ?> label="Catégorie racine">Aucune</optoin>
			<?php function optionsTree($categories,$values,$prefix = "") { ?>
				<?php foreach ($categories as $category) : ?>
						<option 
							<?php if (array_key_exists('parentid',$values)) : ?>
								<?php if ($category->getId() == $values['parentid']) : ?>selected<?php endif; ?>
							<?php endif; ?>
							value="<?php echo $category->getId() ?>"
						><?php echo $prefix.$category->getName() ?></option>
						<?php if (!is_null($category->getChildren())) : ?>
							<?php optionsTree($category->getChildren(),$values, $prefix . "&nbsp;&nbsp;&nbsp;&nbsp;"); ?>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			<?php } ?>

			<?php optionsTree($categories,$values); ?>
		
		</select>
	  </div>
    </div>

    <div class="row">
      <div class="large-12 columns">
	    <hr />
        <div class="right">
			<button type="submit" class="button right" >Valider</button>
			<a class="button secondary right" href="categories.php">Annuler</a>
		</div>
      </div>
    </div>
	
  </fieldset>
