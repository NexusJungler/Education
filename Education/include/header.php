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
                    <li class="desable"><a>Configuration</a>
                        <ul>
                            <li><a href="update.php">mettre à jour les acquis</a></li>
                            <li><a href="addclass.php">ajouter une classe</a></li>
                            <li><a href="addstudent.php">ajouter un élève</a></li>
                            <li class="desable"><a>ajouter un utilisateur</a></li>
                        </ul>
                    </li>
                    <li class="desable"><a>Livrets de compétence</a>
                        <ul>
                            <li><a href="readbook.php">classe 53</a></li>
                            <li><a href="#">classe 38</a></li>
                        </ul>
                    </li>
                    <li class="desable"><a>Outils</a>
                        <ul>
                            <li><a id="S4">graphique étoile</a></li>
                            <li><a href="createdoc.php">créer un document d'évaluation</a></li>
                            <li><a href="#">exporter le livret de l'élève</a></li>
                        </ul>
                    </li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
            <p class="user"> <?php if(isset($_SESSION['login']) && $_SESSION['login']['alpha'] == 1) { echo $_SESSION['login']['pseu'] . ' est connecté!'; } ?></p>
        </header>