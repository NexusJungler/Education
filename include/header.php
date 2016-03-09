 <?php
 $error =  $success = 0;
 ?>
</head>
    <body>
        <header>
            <div class="logo"><img src="images/ENlogo.png"></div>
            <div class="clear"></div>
            <nav>
                <ul class="menu">
                    <li class="desable"><a>Sélection</a>
                        <ul>
                            <li><a href="readpdf.php">charger les évaluations</a></li>
                            <li><a href="#">choisir la classe</a></li>
                        </ul>
                    </li>
                    <li class="desable"><a>Information</a>
                        <ul>
                            <li><a href="readbook.php">livret de compétences de l'élève</a></li>
                            <li><a href="#">récapitulatif pallier maternelle</a></li>
                            <li><a href="#">récapitulatif pallier primaire</a></li>
                            <li><a href="#">récapitulatif pallier secondaire</a></li>
                        </ul>
                    </li>
                    <li class="desable"><a>Configuration</a>
                        <ul>
                            <li><a href="#">ajouter une classe</a></li>
                            <li><a href="adduser.php">ajouter un utilisateur</a></li>
                            <li><a href="addstudent.php">ajouter un élève</a></li>
                        </ul>
                    </li>
                    <li class="desable"><a>Outils</a>
                        <ul>
                            <li><a href="#">requête1</a></li>
                            <li><a id="S4">graphique en étoile</a></li>
                            <li><a href="createdoc.php">créer un document d'évaluation</a></li>
                            <li><a href="#">exporter la requête</a></li>
                        </ul>
                    </li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
            <p class="user"> <?php if(isset($_SESSION['login']) && $_SESSION['login']['alpha'] == 1) { echo $_SESSION['login']['pseu'] . ' est connecté!'; } ?></p>
        </header>