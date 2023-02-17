
<meta charset="UTF-8">
<link rel="stylesheet"  type="text/css"  href="src/bootstrap.min.css"/>
<link rel="stylesheet"   type="text/css"  href="src/styles.css?s=4"/>
</head>
<body>
    <nav class="navbar navbar-dark bg-success plr">
        <a class="navbar-brand d-flex align-items-center " href="index.php"><img style="margin-right: 10px;" src="src/home.ico"/>Gallerie</a>
        <div id="links" class="d-flex justify-content-end">
            <?php
            if (!empty($_SESSION['username'])) {
                ?>
            <span class="d-flex align-items-center text-white">Bonjour : <?php echo $_SESSION['name'];?></span>
                <a class="btn btn-outline-light" href="importer.php">importer</a>
                <a class="btn btn-outline-light" href="mesimages.php">Mes images</a>
                <a class="btn btn-outline-light" href="deconnexion.php">deconnexion</a>
                <?php
            } else {
                ?>
                <a class="btn btn-outline-light" href="connexion.php">connexion</a>
                <a class="btn btn-outline-light" href="enregistrer.php">enregistrer</a>

                <?php
            }
            ?>
        </div> 

    </nav>


