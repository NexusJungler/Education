?<?php
$title = 'adresse';
require_once 'include/doctype.php';
require_once 'include/form_stylesheet.php';
require_once 'include/adresse_stylesheet.php';
require_once 'include/header.php';

if (!isset($_SESSION['adresse'])) {
    $_SESSION['adresse'] = true;
    $input = ["num","voie" ,"complement" ,"cpost" , "ville"];
    for ($i=0; $i<count($input); $i++) {
        $_SESSION['student'][$input[$i]] = '';
    }
}
$newStud= new \Educ\Entity\eleveRepository();
$form = new \Educ\Form\adresse();
$mess= null;
$submit =  isset($_POST['send']);

if ($submit && $form->ok) {
    echo 'validation';
    $newStud->insert($form->student);
    $mess = $form->student->getLastName() . ' vient d\'être ajouté avec succès!';
    $success = 1;
    unset($_SESSION['student']);
    unset($_SESSION['adresse']);
    unset($_SESSION['photopath']);
}
if ($submit && !$form->ok) {$mess = $form->print; $error = 1;}
if (!$submit)  {   ?>
<section>
    <article>
        <form method="post" action="<?= filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING); ?>" >
            <p class="title">Adresse</p>
            <div class="content">
                <p class="bloc">
                    <label for="num">Numéro:</label><input type="text" name="num" id="num" maxlength="8" value="<?= $_SESSION['student']['num'] ?>"><br/>
                </p>
                <p class="bloc">
                    <label for="voie">Voie:</label><input type="text" name="voie" id="voie" maxlength="8" value="<?= $_SESSION['student']['voie'] ?>"><br/>
                </p>
                <p class="bloc">
                    <label for="complement">Complément:</label><input type="text" name="complement" id="complement" maxlength="25" value="<?= $_SESSION['student']['complement'] ?>"><br/>
                </p>
                <p class="bloc">
                    <label for="cpost">Code postal:</label><input type="text" name="cpost" id="cpost" maxlength="5" value="<?= $_SESSION['student']['cpost'] ?>"><br/>
                </p>
                <p class="bloc">
                    <label for="ville">Ville:</label><input type="text" name="ville" id="ville" maxlength="12" value="<?= $_SESSION['student']['ville'] ?>">
                </p>
            </div>
            <button type="submit" name="send">Valider</button>
        </form>
<?php }
require_once 'include/message.php' ;
?>
    </article>
</section>
<?php
require_once 'include/footer.php';
?>
<script src="js/index.js"></script>
<script>
    var Terminator = Object.create(Skynet);
    Terminator.error = <?= $error ?>;
    Terminator.success = <?= $success ?>;
</script>
<?php
require_once 'include/endFile.php';
?>
