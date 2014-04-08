<?php

require ("../autoload.php");

$controller = new Museo\Controller\DevController();
$controller->initAction();

$_SESSION['message'] = "Les données ont été complétement supprimés et regénérés avec succès";

header('Location: museums.php');
