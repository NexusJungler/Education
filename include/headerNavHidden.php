</head>
<body>
<div class="marge"></div>
<header>
    <div class="logo"><img src="images/ENlogo.png"></div>
    <div class="clear"></div>
    <nav>
        <ul class="menu">
            <?php if( isset($log) ) { ?>
                <li><a>S�lection</a>
                    <ul>
                        <li><a>charger les �valuations</a></li>
                        <li><a>choisir la classe</a></li>
                        <li><a>choisir l'�l�ve</a></li>
                    </ul>
                </li>
                <li><a>Information</a>
                    <ul>
                        <li><a href="readbook.php">livret de comp�tences de l'�l�ve</a></li>
                        <li><a>r�capitulatif pallier maternelle</a></li>
                        <li><a>r�capitulatif pallier primaire</a></li>
                        <li><a>r�capitulatif pallier secondaire</a></li>
                    </ul>
                </li>
                <li><a>Configuration</a>
                    <ul>
                        <li><a href="adduser.php">ajouter un utilisateur</a></li>
                        <li><a href="addstudent.php">ajouter un �l�ve</a></li>
                        <li><a>ajouter un moyen de compensation</a></li>
                        <li><a>cr�er un document d'�valuation</a></li>
                    </ul>
                </li>
                <li><a>Outils statistiques</a>
                    <ul>
                        <li><a>requ�te1</a></li>
                        <li><a>requ�te2</a></li>
                        <li><a>graphique en �toile</a></li>
                        <li><a>exporter la requ�te</a></li>
                    </ul>
                </li>
                <li><a href="#">Logout</a></li>
            <?php } else { ?>
                <li><a href="login.php">Login</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>