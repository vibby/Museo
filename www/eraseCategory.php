<?php

require ("../autoload.php");

$controller = new Museo\Controller\CategoryController();
$data = $controller->eraseAction();
extract($data);

$_SESSION['message'] = "Catégorie supprimée avec succès";

header('Location: categories.php');

