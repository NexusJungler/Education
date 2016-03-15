<?php
require_once 'vendor/autoload.php';
include '../qrcodeEncoder/qrlib.php';
include '../html2pdf-4.5.0/vendor/autoload.php';
$studReposit = new \Educ\Entity\eleveRepository();
$userReposit = new \Educ\Entity\utilisateurRepository();
$compReposit = new \Educ\Entity\competenceRepository();
session_start();
$content = $_GET['data'];
$class = $studReposit->getAll($content[0]);
$style= '<style type="text/Css">
page {
    font-family:Times;
}
h1 {
    font-size:28px;
    margin-bottom:50px;
    text-align:center;
    color:black;
    background-color: aqua;
}
table {
    width:100%;
}
.qrcode {
    float: left;
    margin-top:-30px;
    margin-left:30px;
}
.reference {
    margin-left:25px;
    font-size:18px;
    font-weight:bold;
}
.content {
    font-family:kunstler;
    font-size:32px;
    padding-top: 20px;
}
.intitule {
    width:65%;
    padding-right:20px;
    overflow: hidden;
}
span {
    color: blue;
}
</style>';
$pdf_build = $style;
for($j=0; $j<count($class); $j++) {
    $qrc = $content[0] .'|' .  $class[$j]->id . '|' . date("Y-m-d") . '|' . $content[1] . '|' ;
    $path =  'temp/qrc' . $j. '.png';
    for($i=0; $i<$content[1]; $i++) {
        $qrc .=  $content[$i+2] . '|' ;
    }
    QRcode::png($qrc, $path);
    $entete = '<page><h1>Evaluation LPC ASH</h1><img class="qrcode" src="' . $path . '"><table class="reference"><tr><td style="width: 30%;">Classe: <span>'.$content[0].'</span></td> <td>Professeur: <span>'. $_SESSION['login']['pseu'] .'</span></td></tr><tr><td style="width: 30%;">Date: <span>' . date("d-m-Y") . '</span></td><td>Eléve: <span>' . $class[$j]->prenom . ' ' . $class[$j]->nom .'</span></td></tr></table>';
    $table = '<table class="content">';
    for($i=0; $i<$content[1]; $i++) {
        $table .= '<tr><td style="font-size:70px;height:100px;">' . ($i+1) .'|</td><td class="intitule">' . $compReposit->getVal($content[$i+2]) .  '</td><td><img src="images/emptycells.png"></td></tr>';
    }
    $table .= '</table></page>';
    $pdf_build .= $entete . $table;
}
$html2pdf = new HTML2PDF('P','A4','fr');
$html2pdf->WriteHTML($pdf_build);
$html2pdf->Output('Evaldoc'.date('d-m-Y') .'.pdf');
for($i=0; $i<count($class); $i++) {
     unlink('temp/qrc' . $i. '.png');
}
















