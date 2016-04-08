<?php
$title = 'ajouter une classe';
require_once 'include/doctype.php';
require_once 'include/form_stylesheet.php';
require_once 'include/addclass_stylesheet.php';
require_once 'include/header.php';

if (!isset($_SESSION['class'])) {
    $_SESSION['class'] = [
        "name" => '',
        "time" => ''
    ];
}

$newClass = new \Educ\Entity\classeRepository();
$formLog = new \Educ\Form\addClass();
$mess= null;
$submit =  isset($_POST['send']);

if ($submit && $formLog->ok) {
    $newClass->insert($formLog->Class);
    $mess = 'La classe '. $formLog->Class->getNom() . ' vient d\'être ajoutée!';
    $success = 1;
    unset($_SESSION['class']);
}
if ($submit && !$formLog->ok) {$mess = $formLog->print; $error = 1;}
if (!$submit)  {   ?>
    <article>
        <form method="post" action="<?= filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING); ?>">
            <p class="title">Ajouter une classe</p>
            <p class="bloc"><label for="p1">Nom:</label><input type="text" name="name" id="p1" maxlength="4" value="<?= $_SESSION['class']['name'] ?>"></p>
            <p class="bloc"><label for="p2">Année:</label><input type="text" name="time"  id="p2" maxlength="4" value="<?= $_SESSION['class']['time'] ?>"></p>
            <button type="submit" name="send">Valider</button>
        </form>
        <?php }
        require_once 'include/message.php' ;
        ?>
    </article>
    <?php
    require_once 'include/footer.php';
    ?>
</section>
<script src="js/index.js"></script>
<script>
    var Terminator = Object.create(Skynet);
    Terminator.error = <?= $error ?>;
    Terminator.success = <?= $success ?>;
</script>
<?php
require_once 'include/endFile.php';
?>

