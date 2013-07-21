
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
        <input	 class="name <?php if (array_key_exists('name',$errors)) : ?>error<?php endif; ?>" type="text" name="museum[name]" placeholder="Nom du musée"
			<?php if (array_key_exists('name',$values)) : ?>
				value="<?php echo $values['name'] ?>"
			<?php endif; ?>
		>
      </div>
    </div>

    <div class="row">
      <div class="large-12 columns">
        <label>Description</label>
		<?php if (array_key_exists('description',$errors)) : ?>
			<label class="alert"> 
				<?php foreach ($errors['description'] as $error) : ?>
					<?php echo $error ?>
				<?php endforeach; ?>
			</label> 
		<?php endif; ?>
        <textarea name="museum[description]"><?php if (array_key_exists('description',$values)) : ?><?php echo $values['description'] ?><?php endif; ?></textarea>
      </div>
    </div>
	
    <div class="row">
      <div class="large-12 columns">
        <label>Catégories</label>
		<?php if (array_key_exists('categories',$errors)) : ?>
			<span class="alert"> 
				<?php foreach ($errors['categories'] as $error) : ?>
					<?php echo $error ?>
				<?php endforeach; ?>
			</span> 
		<?php endif; ?>
		<select multiple name="museum[categories][]" id="categories">
			<?php function optionsTree($categories,$values,$prefix = "") { ?>
				<?php foreach ($categories as $category) : ?>
						<option 
							<?php if ($prefix == "") : ?>
								disabled
							<?php endif; ?>
							<?php if (array_key_exists('categories',$values) && is_array($values['categories'])) : ?>
								<?php if (in_array($category->getId(),$values['categories'])) : ?>selected<?php endif; ?>
							<?php endif; ?>
							label="<?php $category->getName() ?>"
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
			<a class="button secondary right" href="museums.php">Annuler</a>
		</div>
      </div>
    </div>
	
  </fieldset>
