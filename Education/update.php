<?php
    $title = 'update';
    require_once 'include/doctype.php';
    require_once 'include/update_stylesheet.php';
    require_once 'include/header.php';
    $pdflib = new Educ\Utils\Pdflib();
    $files = scandir('numerisations');
    $nbrfile = count($files);
    $nbrpge = [];
?>
    <p><input type="button" id="showme" value="Show Console"></p>
    <div class="console invisible">
        <input type="button" id="hideme" value="X">
        <div class="script">
            <h3>Education@Console <span><?= $_SESSION['login']['pseu'] ?></span> ~</h3>
            <p>> Contenu du dossier parent :</p>
            <?php
            for($i=2; $i<$nbrfile-1; $i++) {
                $nbrpge[$i-2] = $pdflib->getNumPages('numerisations/' . $files[$i]);
                echo '<p>> ' . ($i-1) . ' - ' . $files[$i] . ' - ' . $nbrpge[$i-2] . ' pages</p>';
            }
            ?>
            <br>
            <p>> Ouverture du fichier <?= $files[2]?></p>
            <p>>  Page 1 - chargement, veuillez patienter...</p>
        </div>
    </div>
    <article>
        <div class="tableread">
        </div>
    </article>
<?php
    require_once 'include/footer.php';
    $i = 0;
?>
</section>
<script type="text/javascript" src="js/xhr.js"></script>
<script type="text/javascript" src="js/update.js"></script>
<script>
    var joe = Object.create(Consol);
    joe.nbrFile = <?= $nbrfile-3 ?>;
    for(var i=0; i<joe.nbrFile; i++) {
        joe.nbrPage[i] = <?= $nbrpge[$i] ?>;
        <?php $i++; ?>
    }
    joe.init();
</script>

