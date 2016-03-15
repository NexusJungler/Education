<?php
require_once '../vendor/autoload.php';
$status = new Educ\Entity\validationRepository();
$id= $_POST['id'];  $cat = $_POST['c'] ;
$content = $status->getAll($id, $cat);
echo json_encode($content);