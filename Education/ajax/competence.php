<?php
require_once '../vendor/autoload.php';
$items = new Educ\Entity\competenceRepository();
$d = $_POST['d']; $c = $_POST['c'];
$content = $items->getCompetence($d, $c, true);
 echo json_encode($content);