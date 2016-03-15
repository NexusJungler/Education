<?php
require_once '../vendor/autoload.php';
$strep = new Educ\Entity\eleveRepository();
$vdrep = new Educ\Entity\validationRepository();
$id = $_POST['stud']; $class = $_POST['class'];
$long = count($strep->getAll($class));
$content = $strep->getOne($class, $id);
$birth = new DateTime($content->age);
$now = new DateTime(date('Y-m-d'));
$interval = $now->diff($birth);
$content->age = $interval->format('%y ans');
$content->succes =  $vdrep->getSuccess($id);
$content->total = $long;
echo json_encode($content);