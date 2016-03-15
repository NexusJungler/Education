<?php
require_once '../vendor/autoload.php';
$data = new Educ\Entity\competenceRepository();
$d = $_POST['d'];
$content = $data->getCategorie($d);
echo json_encode($content);