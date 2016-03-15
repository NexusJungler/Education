<?php
require_once '../vendor/autoload.php';
$data = new Educ\Entity\eleveRepository();
$class = $_POST['class'];
$content = $data->getPrimaryKeysOrdered($class);
echo json_encode($content);
