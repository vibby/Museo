<?php

require ("../autoload.php");

$controller = new Museo\Controller\MuseumController();
$data = $controller->modifyAction();
extract($data);

header('Location: '.$redirect);
