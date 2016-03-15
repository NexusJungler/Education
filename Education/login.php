<?php
    $title = 'login';
    require_once 'include/doctype.php';
    require_once 'include/form_stylesheet.php';
    require_once 'include/login_stylesheet.php';
    require_once 'include/header.php';

    $user = new \Educ\Entity\utilisateurRepository();
    $form = new \Educ\Form\log();
    $mess = null;
    $submit =  isset($_POST['send']);

    if ($submit && $form->ok) {
        $cible =  $user->find($_SESSION['login']['pseu']);
        if (!empty($cible) ) {
            if (password_verify($_SESSION['login']['pass'], $cible->getPass()) ) {
                $mess = 'Bienvenue ' . $cible->getName(). '! Bonne session à vous!' ;
                $success = 1;
                $_SESSION['login']['alpha']= $cible->getIdentity($_SESSION['login']['pseu']);
                unset($_SESSION['login']['pass']);
            }  else { $error=1; $mess = 'Le mot de passe est incorrect!' ;}
        }  else { $error=1; $mess = 'Vous n\'êtes pas encore inscrit, contactez l\'administrateur de votre réseau!';}
    }
    if ($submit && !$form->ok) {$mess = $form->print; $error = 1;}
    if (!$submit)  {
?>
<section>
    <article>
        <form method="post" action="<?= filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING); ?>">
            <p class="title">login</p>
            <p class="bloc"><label for="toto">pseudo:</label><input type="text" name="pseu" id="toto" maxlength="40" value="<?= $_SESSION['login']['pseu'] ?>"></p>
            <p class="bloc"><label for="titi">password:</label><input type="password" name="pass" id="titi" maxlength="15" value="<?= $_SESSION['login']['pass'] ?>"></p>
            <button type="submit"  name="send">Valider</button>
            </form>
        <?php }
        require_once 'include/message.php';
        ?>
    </article>
    <div class="clear"></div>
    <?php
    require_once 'include/footer.php';
    ?>
</section>
<script src="js/index.js"></script>
<script>
    var Terminator = Object.create(Skynet);
    Terminator.error = <?= $error ?>;         /* Est-ce qu'il y a une erreur à signaler ?   */
    Terminator.success = <?= $success ?>;      /* Est-ce qu'un formulaire a été validé en respectant toutes les contraintes ? */
</script>
<?php
require_once 'include/endFile.php';
?>
