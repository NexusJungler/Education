<?php
require_once 'vendor/autoload.php';
session_start();

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = [
        "alpha"  => 0,
        "pseu" => '',
        "pass" => ''
    ];
}
if (isset($_SESSION['photopath']))  {
    unlink($_SESSION['photopath']);
    unset($_SESSION['photopath']);
}

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link href='https://fonts.googleapis.com/css?family=Mr+Dafoe' rel='stylesheet' type='text/css'>


