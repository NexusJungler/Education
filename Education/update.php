<?php
$title = 'readBMP';
require_once 'include/doctype.php';
require_once 'include/update_stylesheet.php';
require_once 'include/header.php';
require_once '../qrcodeDecoder/lib/QrReader.php';
$studReposit = new \Educ\Entity\eleveRepository();
$compReposit = new \Educ\Entity\competenceRepository();
$query = new \Educ\Entity\validationRepository();
$myWork = new Educ\Entity\algo();
$pdfUtil = new Educ\Utils\Pdflib();

//  lecture du dossier entrep�t des num�risations

$files = scandir('numerisations');
$nbrfiles = count($files);
for($x=2; $x<$nbrfiles; $x++) {
    $nbrpages = $pdfUtil->getNumPages('numerisations/' . $files[$x]);
    for ($z = 0; $z < $nbrpages; $z++) {
        exec("convert numerisations/" . $files[$x] . "[" . $z . "] -resize 850x1169 -depth 4  temp/workdoc.png");
        $src = imagecreatefrompng('temp/workdoc.png');

        // extraction qrcode image

        $dest = imagecreatetruecolor(100, 100);
        imagecopy($dest, $src, 0, 0, 85, 118, 100, 100);
        imagepng($dest, 'temp/Qrcod.png');
        imagedestroy($dest);

        // extraction donn�es qrcode

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
        unlink('temp/Qrcod.png');

        // extraction des cellules

        $dest = imagecreatetruecolor(215, 580);
        imagecopy($dest, $src, 0, 0, 600, 240, 215, 580);
        imagepng($dest, 'temp/Cell.png');
        imagedestroy($dest);
        exec('convert temp/Cell.png temp/Cell.bmp');
        unlink('temp/Cell.png');

        // convert cellules to monochrome
        $myWork->convert_to_monochrome();

        // calcul decalage

        $j = 0;
        $decal = [];
        while ($decal == null) {
            $j++;
            $decal = $myWork->checkline($j);
        }
        $tableCell = $myWork->readCell($decal [0], $decal[1]);

        // association de la valeur des cellules avec les comp�tences cibl�es
            // Extraction de la valeur des cellules

        $wordCell = [];
        for ($j = 0; $j < $data['nbrItem']; $j++) {
            $wordCell[$j] = '';
            for ($i = 1; $i < 6; $i++) {
                if ($tableCell[$j * 5 + $i] > 50) {
                    $wordCell[$j] .= '1';
                } else {
                    $wordCell[$j] .= '0';
                }
            }
        }
        unlink('temp/CellMn.bmp');

            // Link comp�tences
        for ($i = 0; $i < $data['nbrItem']; $i++) {
            $cut = strpos($responseText, '|', $offset);
            $compID = substr($responseText, $offset, $cut - $offset);
            $data['competences'][$compID] = $myWork->getIntValue($wordCell[$i]);
            $offset = $cut + 1;
        }

        // traitement de la valeur des cellules

        $evaldate = new DateTime($data['date']);
        $evaldate = $evaldate->format('d/m/Y');
        $html = '<h2>Evaluation du ' . $evaldate . '</h2><h3>R�sultats de ' . $data['eleve'] . ':</h3>';
        $ind = 0;
        foreach ($data['competences'] as $key => $value) {
            $intitule = $compReposit->getVal($key);
            $ind++;
            if ($value == 16) {
                $html .= '<p>' . $ind . '/ ' . $intitule . '</p><p class="response green">Comp�tence valid�e ';

                /*  R�cup�ration de l'id de l'�l�ve � partir de son nom et de son pr�nom
                $cut = strpos($data['eleve'], ' ');
                $name = [];
                $name[0] = substr($data['eleve'], 0, $cut);
                $name[1] = substr($data['eleve'], $cut + 1);
                $who = $studReposit->getId($data['classe'], $name);
                */

                $state = $query->getState($who, $key);
                if ($state == 1) {
                    //   La comp�tence n'a jamais �t� valid�e ==> Ecriture d'une nouvelle entr�e n�cessaire
                    $html .= 'pour la premi�re fois, f�licitations!</p>';
                    $validate = new \Educ\Entity\validation();
                    $validate->setFKeleve($who);
                    $validate->setFKcompetence($key);
                    $validate->setFirst($data['date']);
                    $validate->setFKcompensation(1);
                    $validate->setFKetat(2);
                    $query->insert($validate);
                } else {
                    $updateok = true;
                    $html .= 'une nouvelle fois par l\'�l�ve, ce qui porte � ' . ($state - 1) . ' le nombre de ses validations.</p>';
                    if ($state == 4) {
                        $html .= '<p class="response red">Cette comp�tence est d�j� amplement acquise pour lui, l\'�valuation doit �tre ignor�e.</p>';
                        $updateok = false;
                    }
                    $dates = $query->getValidationDate($who, $key);
                    foreach ($dates as $pos => $time) {
                        if ($time == $data['date'] && $updateok) {
                            $html .= '<p class="response red">La date de validation de la comp�tence par l\'�l�ve figure d�j� au registre. L\'�valuation ne peut pas �tre prise en compte.</p>';
                            $updateok = false;
                            break;
                        }
                    }
                    if ($updateok) {          //  les informations sont recevables et impliquent la mise � jour d'un enregistrement
                        $html .= 'Ce progr�s substantiel ne doit pas �tre oubli�! Le registre a �t� mis � jour correctement.';
                        $query->update($data['date'], $who, $key);
                    }
                }
            }
            if ($value == 1) {
                $html .= '<p>' . $ind . '/ ' . $intitule . '</p><p class="response red">Comp�tence absolument pas ma�tris�e, l\'�l�ve est en grande difficult� et doit �tre pris en charge.';
            }
            if ($value == 6) {
                $html .= '<p>' . $ind . '/ ' . $intitule . '</p><p class="response green">Comp�tence valid�e par un moyen de compensation mat�riel, f�licitations!';
            }
            if ($value == 8) {
                $html .= '<p>' . $ind . '/ ' . $intitule . '</p><p class="response red">Comp�tence pas vraiment ma�tris�e mais des progr�s sont significatifs, il faut poursuivre les efforts!';
            }
            if ($value == 28) {
                $html .= '<p>' . $ind . '/ ' . $intitule . '</p><p class="response green">Comp�tence valid�e par un moyen de compensation oral, f�licitations!';
            }
            if ($value == 10) {
                $html .= '<p>' . $ind . '/ ' . $intitule . '</p><p class="response red">Comp�tence non ma�tris�e et qui doit �tre retravaill�e en priorit� lors des prochaines s�ances...';
            }
        }
        $html .= '<br>';
   }
    unlink('numerisations/'. $files[$x]);
}
?>

<section>
    <article>
        <div class="tableread">
           <?= $html ?>
        </div>
    </article>
</section>


