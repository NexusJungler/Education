<?php
require_once '../vendor/autoload.php';
$status = new Educ\Entity\validationRepository();
$content = $status->getChartData($_POST['stud']);
echo json_encode($content);