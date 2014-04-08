<?php

require ("../autoload.php");

$controller = new Museo\Controller\MuseumController();
$data = $controller->eraseAction();
extract($data);

$_SESSION['message'] = "Musée supprimé avec succès";

header('Location: museums.php');

