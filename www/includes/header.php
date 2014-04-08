<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<?php $js = "" ?>

  <head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width" />
	<title>Muséo</title>
	<link rel="stylesheet" href="css/foundation.css" />
	<link rel="stylesheet" href="css/museo.css" />
	<link rel="stylesheet" href="select2-3.4.1/select2.css" />
	<link rel="icon" href="favicon.ico" />

	<script src="js/vendor/custom.modernizr.js"></script>
  </head>


<body>

	<div class="row">
		<div class="large-12 columns">
			<h2 class="title">Muséo</h2><span class="subline">Just a CRUD from scratch by Vibby for Naoned</span>
		</div>
	</div>

	<div class="row">
		<div class="large-12 columns">

			<nav class="top-bar">
				  <ul class="title-area">
					<!-- Title Area -->
					<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
					<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
				  </ul>

				  <section class="top-bar-section">
					<!-- Left Nav Section -->
					<ul class="left">
					  <li class="divider"></li>
					  <li><a href="museums.php">Les Musées</a></li>
					  <li class="divider"></li>
					  <li><a href="newMuseum.php" class="button success">Nouveau musée</a></li>
					  <li class="divider"></li>
					  <li><a href="categories.php">Catégorisation</a></li>
					  <li class="divider"></li>
					  <li><a href="newCategory.php" class="button success">Nouvelle catégorie</a></li>
					  <li class="divider"></li>
					</ul>
					<ul class="right">
					  <li class="divider hide-for-small"></li>
					  <li><a href="init.php" class="button alert">Réinitialiser les données</a></li>
					  <li class="divider"></li>
					  <li class="divider"></li>
					</ul>
				  </section>


			</nav>
		</div>
	  </div>


	<?php if (isset($_SESSION) && array_key_exists('message',$_SESSION)) : ?>
		<div class="row">
			<div class="large-12 columns">
				<div class="alert-box success"</div>
					<?php echo $_SESSION['message']; ?>
					<?php unset($_SESSION['message']); ?>
					<a href="" class="close">×</a>
				</div>
			</div>
		  </div>
	<?php endif; ?>


