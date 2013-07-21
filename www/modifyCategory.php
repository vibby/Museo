<?php

require ("../autoload.php");

$controller = new museo\controller\categoryController();
$data = $controller->modifyAction();
extract($data);

header('Location: '.$redirect);
