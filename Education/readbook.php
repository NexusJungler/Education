<?php
    $title = 'readbook';
    require_once 'include/doctype.php';
    require_once 'include/readbook_stylesheet.php';
    require_once 'include/header.php';

    $data = new \Educ\Entity\competenceRepository();
    $class = new \Educ\Entity\eleveRepository();
    $vdrep =   new \Educ\Entity\validationRepository();

?>

<section>
    <div id="page">
    <aside>
        <div class="select">
            <label for="S1">DISCIPLINE</label>
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
            <label for="S2">CATEGORIE</label>
            <select id="S2">
                <option></option>
                <?php
                $cat = $data->getCategorie(1);
                $html = null;
                for ($i=0; $i<count($cat); $i++) {
                    $html .= '<option>' . $cat[$i]['intitule'] . '</option>';
                }
                echo $html;
                ?>
            </select>
        </div>
        <div class="student">
            <?php
            $key = $class->getPrimaryKeysOrdered(53);
            $id = intval($key[0][0]); // fonction getPrimaryKeysOrdered renvoie un array dans un array!
            $student = $class->getOne(53, $id);
            $birth = new DateTime($student->age);
            $now = new DateTime(date('Y-m-d'));
            $interval = $now->diff($birth);
            ?>
            <h2>CLASSE 53</h2>
            <div class="photo"><img src="upload/<?= $student->photo ?>"></div>
            <div class="fleche"></div>
            <div class="fleche droite"></div>
            <div class="info">
                <p>Nom: <span><?= $student->nom ?></span></p>
                <p>Prénom: <span><?= $student->prenom ?></span></p>
                <p>Adresse: <span><?= $student->num . ', ' . $student->voie ?></span></p>
                <p><span><?= $student->complement ?></span></p>
                <p><span><?= $student->cpost . ' ' . $student->ville ?></span></p>
                <p>Age: <span><?= $interval->format('%y ans') ?></span></p>
                <p>Réussite: <span><?= $vdrep->getSuccess($id)?>%</span></p>
            </div>
        </div>
    </aside>
    <article>
        <div class="tableread"></div>
    </article>
    <div class="clear"></div>
    </div>
<?php
require_once 'include/footer.php';
?>
    </section>
    <script src="js/index.js"></script>
    <script src="js/xhr.js"></script>
    <script src="js/book.js"></script>
    <script src="Chart/Chart.js"></script>
    <script src="js/graph.js"></script>
    <script>
        var Terminator = Object.create(Skynet);
        var Jungle = Object.create(book);
        Jungle.init();
    </script>
<?php
require_once 'include/endFile.php';
?>