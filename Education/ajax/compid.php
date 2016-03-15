<?php
require_once '../vendor/autoload.php';
$data = new Educ\Entity\competenceRepository();
$competence = $_POST['cpt'];
$content = $data->getID($competence);
echo json_encode($content);