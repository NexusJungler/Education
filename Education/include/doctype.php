<?php
require_once 'vendor/autoload.php';
session_start();
/* unset($_SESSION['login']) ; */
if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = [
        "alpha"  => 0,
        "pseu" => '',
        "pass" => ''
    ];
    // on peut aussi commencer par d�clarer un tableau vide pour la cl� 'login' et ensuite affecter chaque variable du tableau avec la syntaxe $_SESSION['login'][$var] = $value
}

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/liScroll.css">


