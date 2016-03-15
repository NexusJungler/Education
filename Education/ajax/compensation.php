<?php
require_once '../vendor/autoload.php';
$reposit = new Educ\Entity\compensationRepository();
$content = $reposit->getAll();
echo json_encode($content);