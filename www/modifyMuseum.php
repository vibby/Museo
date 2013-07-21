<?php

require ("../autoload.php");

$controller = new museo\controller\museumController();
$data = $controller->modifyAction();
extract($data);

header('Location: '.$redirect);
