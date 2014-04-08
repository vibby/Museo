<?php

require ("../autoload.php");

$controller = new Museo\Controller\CategoryController();
$data = $controller->modifyAction();
extract($data);

header('Location: '.$redirect);
