</head>
<body>
<div class="marge"></div>
<header>
    <div class="logo"><img src="images/ENlogo.png"></div>
    <div class="clear"></div>
    <nav>
        <ul class="menu">
            <?php if( isset($log) ) { ?>
                <li><a>Sélection</a>
                    <ul>
                        <li><a>charger les évaluations</a></li>
                        <li><a>choisir la classe</a></li>
                        <li><a>choisir l'élève</a></li>
                    </ul>
                </li>
                <li><a>Information</a>
                    <ul>
                        <li><a href="readbook.php">livret de compétences de l'élève</a></li>
                        <li><a>récapitulatif pallier maternelle</a></li>
                        <li><a>récapitulatif pallier primaire</a></li>
                        <li><a>récapitulatif pallier secondaire</a></li>
                    </ul>
                </li>
                <li><a>Configuration</a>
                    <ul>
                        <li><a href="adduser.php">ajouter un utilisateur</a></li>
                        <li><a href="addstudent.php">ajouter un élève</a></li>
                        <li><a>ajouter un moyen de compensation</a></li>
                        <li><a>créer un document d'évaluation</a></li>
                    </ul>
                </li>
                <li><a>Outils statistiques</a>
                    <ul>
                        <li><a>requête1</a></li>
                        <li><a>requête2</a></li>
                        <li><a>graphique en étoile</a></li>
                        <li><a>exporter la requête</a></li>
                    </ul>
                </li>
                <li><a href="#">Logout</a></li>
            <?php } else { ?>
                <li><a href="login.php">Login</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>