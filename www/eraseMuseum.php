<?php

require ("../autoload.php");

$controller = new museo\controller\museumController();
$data = $controller->eraseAction();
extract($data);

$_SESSION['message'] = "Musée supprimé avec succès";

header('Location: museums.php'); 

