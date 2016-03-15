<?php
$title = 'CreateDoc';
require_once 'include/doctype.php';
require_once 'include/form_stylesheet.php';
require_once 'include/createdoc_stylesheet.php';
require_once 'include/header.php';
$data = new \Educ\Entity\competenceRepository();
?>
<section>
    <ul>
        <li>DISCIPLINE</li>
        <li>CATEGORIE</li>
        <li>COMPETENCE</li>
    </ul>
    <nav>
        <select id="S1" >
            <option></option>
            <?php
            $disc = $data->getAll('discipline');
            $long = count($disc);
            $html = null;
            for ($i=0; $i<$long; $i++) {
            $html .= '<option>' . $disc[$i]->intitule . '</option>';
            }
            echo $html;
            ?>
        </select>
        <select id="S2">
        </select>
        <select id="S3">
        </select>
    </nav>
    <div class="clear"></div>
    <input type="button"  class="pull_left" id="add" value="Ajouter">
    <input type="button" class="pull_right" id="sup" value="Supprimer">
    <article>
        <div class="tableread">
            <h3>Edition Document</h3>
            <table></table>
        </div>
        <button id="save">Enregistrer</button>
    </article>
    <?php
    require_once 'include/footer.php';
    ?>
</section>
    <script src="js/index.js"></script>
    <script src="js/xhr.js"></script>
    <script src="js/book.js"></script>
    <script src="js/create.js"></script>
    <script>
        var Connor = Object.create(book);
        var Terminator = Object.create(Skynet);
        Terminator.init();
        Connor.create = true;
        Connor.init();
    </script>
<?php
require_once 'include/endFile.php';
?>














<?php
/*
<?php
$cat = $data->getCategorie(1);
$html = null;
for ($i=0; $i<count($cat); $i++) {
    $html .= '<option>' . $cat[$i]['intitule'] . '</option>';
}
echo $html;


  $comp = $data->getCompetence(1, 1);
  $html = null;
  for ($i=0; $i<count($comp); $i++) {
 $html .= '<option>' . $comp[$i]->intitule . '</option>';
  }
  echo $html;
  ?>       */
?>