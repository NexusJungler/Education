<?php
$title = 'ajouter un utilisateur';
require_once 'include/doctype.php';
require_once 'include/form_stylesheet.php';
require_once 'include/adduser_stylesheet.php';
require_once 'include/header.php';

if (!isset($_SESSION['user'])) {
$_SESSION['user'] = [
    "pseu" => '',
    "pass" => ''
    ];
}

$newUser = new \Educ\Entity\utilisateurRepository();
$formLog = new \Educ\Form\addUser();
$mess= null;
$submit =  isset($_POST['send']);

if ($submit && $formLog->ok) {
    $newUser->insert($formLog->userClass);
    $mess = $formLog->userClass->getName() . ' vient d\'être ajouté avec succès!';
    $success = 1;
    unset($_SESSION['user']);
}
if ($submit && !$formLog->ok) {$mess = $formLog->print; $error = 1;}
if (!$submit)  {   ?>
    <section>
        <article>
            <form method="post" action="<?= filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING); ?>">
                    <p class="title">Ajouter un utilisateur</p>
                    <p class="bloc"><label for="toto">pseudo:</label><input type="text" name="pseu" id="toto" maxlength="18" value="<?= $_SESSION['user']['pseu'] ?>"></p>
                    <p class="bloc"><label for="titi">password:</label><input type="password" name="pass"  id="titi" maxlength="10" value="<?= $_SESSION['user']['pass'] ?>"></p>
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

