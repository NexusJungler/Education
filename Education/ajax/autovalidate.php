<?php
require_once '../vendor/autoload.php';
$query = new Educ\Entity\validationRepository();
$items = $_POST['data'];
$student = $_POST['stud'];
$const = 7;

foreach($items as $value) {
    $state = $query->getState($student, $value);
    if($state == 1) {
        $validate = new Educ\Entity\validation();
        $validate->setFKeleve($student);
        $validate->setFKcompetence($value);
        $validate->setFirst(date("Y-m-d"));
        $validate->setSecond(date("Y-m-d"));
        $validate->setLast(date("Y-m-d"));
        $validate->setFKcompensationA($const);
        $validate->setFKcompensationB($const);
        $validate->setFKcompensationC($const);
        $validate->setFKetat(4);
        $query->insert($validate);
    } else {
        while($state < 4) {
            $query->update(date("Y-m-d"), $student, $value, $const);
            $state++;
        }
    }
}
echo json_encode('query executed!');