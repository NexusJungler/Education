<?php
    require_once '../vendor/autoload.php';
    require_once '../../qrcodeDecoder/lib/QrReader.php';
    $studReposit = new \Educ\Entity\eleveRepository();
    $compReposit = new \Educ\Entity\competenceRepository();
    $query = new \Educ\Entity\validationRepository();
    $myWork = new Educ\Entity\algo();

    //  lecture du dossier entrepôt des numérisations
        chdir('../');
        $files = scandir('numerisations');
        $html =  '';

    // extraction data images
        exec("convert -density 500 numerisations/" . $files[$_POST['file']+1] . "[" . $_POST['page'] . "] -crop 490x480+280+390 temp/Qrcod.bmp");
        exec("convert -density 100 numerisations/" . $files[$_POST['file']+1] . "[" . $_POST['page'] . "] -crop 215x580+570+240 temp/Cell.bmp");
        $myWork->pass_to_black();

    // extraction données qrcode

        $data = [];
        $offset = 0;
        $key = ['classe', 'eleve', 'date', 'nbrItem', 'competences'];
        $qrcode = new QrReader('temp/Qrcod.png');
        $responseText = $qrcode->text();
        for ($i = 0, $pos = 0; $i < 4; $i++) {
            $pos = strpos($responseText, '|', $offset);
            $item = substr($responseText, $offset, $pos - $offset);
            if ($i < 3) {
                $data[$key[$i]] = $item;
            } else {
                $data[$key[$i]] = intval($item);
            }
            $offset = $pos + 1;
        }
        $who = $data['eleve'];
        $stud = $studReposit->getOne($data['classe'], $data['eleve']);
        $data['eleve'] = $stud->getLastName() . ' ' . $stud->getName();

        // extraction des cellules
         $myWork->convert_to_monochrome();
        for($i=0; $i<$data['nbrItem']; $i++) {
           $tableCell[$i] = $myWork->readCell($i);
       }

        // Association de la valeur des cellules avec les compétences ciblées
            // Extraction des mots de 5bits de chaque item

        $wordCell = [];
        for ($j = 0; $j < $data['nbrItem']; $j++) {
            $wordCell[$j] = '';
            for ($i = 1; $i < 6; $i++) {
                if ($tableCell[$j][ $i] >= 44) {
                    $wordCell[$j] .= '1';
                } else {
                    $wordCell[$j] .= '0';
                }
            }
        }

            // Liaison avec les compétences
        for ($i = 0; $i < $data['nbrItem']; $i++) {
            $cut = strpos($responseText, '|', $offset);
            $compID = substr($responseText, $offset, $cut - $offset);
            $data['competences'][$compID] = $myWork->getIntValue($wordCell[$i]);
            $offset = $cut + 1;
        }


        // Traitement de la valeur des mots

        $evaldate = new DateTime($data['date']);
        $evaldate = $evaldate->format('d/m/Y');
        if($_POST['page'] == 0) {
            $html .= '<h2>Evaluation du ' . $evaldate . '</h2>';
        }
        $html .= '<h3>Résultats de ' . $data['eleve'] . ':</h3>';
        $ind = 0;
        foreach ($data['competences'] as $key => $value) {
            $intitule = $compReposit->getVal($key);
            $ind++;
            $compensation =1;
            $html .= '<p>' . $ind . '/ ' . $intitule . '</p>';
            if ($value == 0) {
                $html .= '<p class="response red">Les cellules de la compétence sont vides.';
            }
            if ($value == 16 || $value == 6 ||$value == 28|| $value == 12 ||$value == 7 || $value == 30 ) {
                $html .= '<p class="response green">Compétence validée ';
                if($value == 6) {$html .= 'par un moyen de compensation matérielle '; $compensation++;}
                if($value == 28) {$html .= 'par un moyen de compensation orale '; $compensation=4;}
                if($value == 7) {$html .= 'par un moyen de compensation écrite '; $compensation=3;}
                if($value == 12) {$html .= 'par un moyen de compensation temporelle '; $compensation=5;}
                if($value == 30) {$html .= 'par un moyen de compensation humaine '; $compensation=6;}

                $state = $query->getState($who, $key);
                if ($state == 1) {
                    //   La compétence n'a jamais été validée ==> Ecriture d'une nouvelle entrée dans la base
                    $html .= 'pour la première fois, félicitations!</p>';
                    $validate = new \Educ\Entity\validation();
                    $validate->setFKeleve($who);
                    $validate->setFKcompetence($key);
                    $validate->setFirst($data['date']);
                    $validate->setFKcompensationA($compensation);
                    $validate->setFKcompensationB(1);
                    $validate->setFKcompensationC(1);
                    $validate->setFKetat(2);
                    $query->insert($validate);
                } else {
                    $updateok = true;
                    $html .= 'une nouvelle fois par l\'élève, ce qui porte à ' . $state. ' le nombre de ses bons résultats.</p>';
                    if ($state == 4) {
                        $html .= '<p class="response red">Cependant, cette compétence est déjà amplement acquise pour lui, l\'évaluation doit être ignorée.</p>';
                        $updateok = false;
                    }
                    $dates = $query->getValidationDate($who, $key);
                    foreach ($dates as $pos => $time) {
                        if ($time == $data['date'] && $updateok) {
                            $html .= '<p class="response red ">Cependant, le registre fait déjà état du même progrès à la date considérée. L\'évaluation ne peut pas être prise en compte.</p>';
                            $updateok = false;
                            break;
                        }
                    }
                    if ($updateok) {          //  les informations sont recevables => mise à jour de la base
                        $html .= 'Ce progrès substantiel ne doit pas être oublié! Le registre a été mis à jour correctement.';
                        $query->update($data['date'], $who, $key, $compensation);
                    }
                }
            }
            if ($value == 1) {
                $html .= '<p class="response red">Compétence absolument pas maîtrisée, l\'élève est en grande difficulté et doit être pris en charge.';
            }
            if ($value == 8) {
                $html .= '<p class="response red">Compétence pas vraiment maîtrisée mais des progrès sont significatifs, il faut poursuivre les efforts!';
            }
            if ($value == 10) {
                $html .= '<p class="response red">Compétence non maîtrisée et qui doit être retravaillée en priorité lors des prochaines séances...';
            }
            if ($value != 16 && $value != 6 && $value != 28 && $value != 12 && $value != 7 && $value !=30 && $value != 1 && $value != 8 && $value != 10) {
                    $html .= '<p class="response red">Cette valeur (' .$value . ') n\'a pas encore été définie.';
            }
        }
        $html .= '</p><br>';

//unlink('numerisations/'. $files[$x]);
echo json_encode($html);



    /* code Imagick PHP extend
$path = 'numerisation/Evalchecked.pdf';
$workdoc = new Imagick($path.'[0]'); // [0] indicate the number of the wanted page
$workdoc->setResolution(100,100);
$workdoc->setImageFormat("png");
                           [$workdoc->writeImage("png:numerisation/eval1.png");        On force le format avec préfixe
                            $workdoc->destroy;]

$QrImg = imagecreatetruecolor(110, 100);
imagecopy($QrImg, $img, 0, 0, 80, 80, 110, 100);
$QrData = new QrReader($QrImg);
$response = $QrData->text();

                                                                                           */
