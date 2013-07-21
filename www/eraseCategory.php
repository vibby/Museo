<?php

require ("../autoload.php");

$controller = new museo\controller\categoryController();
$data = $controller->eraseAction();
extract($data);

$_SESSION['message'] = "Catégorie supprimée avec succès";

header('Location: categories.php'); 

