<?php
if ($success==1) { $color = 'green'; ?>
    <section>
    <article>
    <p class="onsuccess"><?= $mess ?></p>
<?php }
if ($error==1) { $color = 'red'; ?>
    <section>
    <article>
    <p class="error"><?= $mess ?></p>
<?php }