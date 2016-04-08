 <?php
 $error =  $success = 0;
 $classRep = new Educ\Entity\classeRepository();
 ?>
</head>
    <body>
        <header>
            <div class="logo"><img src="images/ENlogo.png"></div>
            <div class="clear"></div>
            <nav>
                <ul class="menu">
                    <li class="desable"><a>Configuration</a>
                        <ul>
                            <li><a href="update.php">mettre à jour le registre</a></li>
                            <li><a href="addclass.php">ajouter une classe</a></li>
                            <li><a href="addstudent.php">ajouter un élève</a></li>
                            <li class="desable"><a>ajouter un utilisateur</a></li>
                        </ul>
                    </li>
                    <li class="desable"><a>Livrets de compétence</a>
                        <ul>
                            <?php
                            $allClass = $classRep->getAll($_SESSION['login']['alpha']);
                            $what = null;
                            if(isset($_GET['cl'])) {$what = $_GET['cl'];}
                            foreach($allClass as $value) {?>
                            <li><a href="readbook.php?cl=<?=$value ?>">parcourir la classe <?=$value ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="desable"><a>Outils</a>
                        <ul>
                            <li><a id="S4">afficher le graphique des compétences</a></li>
                            <li><a href="createdoc.php?cl=<?= $what?>">éditer un document d'évaluation</a></li>
                            <li><a href="#">exporter le livret de l'élève</a></li>
                        </ul>
                    </li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </header>
        <section>
        <p class="user"> <?php if(isset($_SESSION['login']) && $_SESSION['login']['alpha'] == 1) { echo $_SESSION['login']['pseu'] . ' est connecté!'; } ?></p>

