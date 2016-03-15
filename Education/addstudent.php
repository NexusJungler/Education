<?php
$title = 'ajouter un élève';
require_once 'include/doctype.php';
require_once 'include/form_stylesheet.php';
require_once 'include/addstudent_stylesheet.php';
require_once 'include/header.php';

if (!isset($_SESSION['student'])) {
    $_SESSION['student'] = [
        "nom" => '',
        "prenom" => '' ,
        "age" =>  ''
    ];
}
if (isset($_SESSION['photopath']))  {
    unlink($_SESSION['photopath']);
}
$form = new \Educ\Form\addStudent();
$mess= null;
$submit =  isset($_POST['send']);

if ($submit && $form->ok) {
 header('location:adresse.php');
}
if ($submit && !$form->ok) {$mess = $form->print; $error = 1;}
if (!$submit)  {
?>
<section>
    <article>
        <form method="post" action="<?= filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING); ?>" enctype="multipart/form-data">
            <p class="title">Ajouter un élève</p>
            <div class="content">
                <p class="bloc">
                    <label for="nom">Nom:</label><input type="text" name="nom" id="nom" maxlength="25" value="<?=  $_SESSION['student']['nom'] ?>"><br/>
                </p>
                <p class="bloc">
                    <label for="prenom">Prénom:</label><input type="text" name="prenom" id="prenom" maxlength="25" value="<?=  $_SESSION['student']['prenom'] ?>"><br/>
                </p>
                  <p class="bloc">
                      <label for="birthday">Date de naissance:</label><input type="text" name="age" id="birthday" maxlength="10" placeholder="jj/mm/aaaa" value="<?=  $_SESSION['student']['age'] ?>"<br/>
                  </p>
                <p class="bloc">
                    <label for="photo">Photo:</label><input type="file" name="photo" id="photo" required>
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
