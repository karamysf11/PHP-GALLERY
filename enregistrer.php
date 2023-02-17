<?php
require "classes/Utilisateur.php";

session_start();
if (!empty($_SESSION['username']))
    header("Location: index.php");

$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["nom"]) && isset($_POST["password"])) {

    $nouveauUtilisateur = new Utilisateur();
    $nouveauUtilisateur->setNom($_POST["nom"]);
    $nouveauUtilisateur->setUsername($_POST["username"]);
    $nouveauUtilisateur->setPassword(md5($_POST["password"]));

    if ($nouveauUtilisateur->enregistrer())
        $msg = "vous avez bien enregistrer";
    else
        $msg = "username déja inscris";
}
?>


<html>
    <head>
        <title>enregistrer</title>

        <?php include './header.php'; ?>

        <div class="container d-flex flex-lg-wrap justify-content-center">

            <?php echo $msg; ?>

            <div class="container d-flex justify-content-center">
                <form action="enregistrer.php" method="POST" class="frm bg-light">
                    <h2 class="text-center">S'enregistrer</h2>       

                    <input type="text" class="form-control"  placeholder="Nom complet" name="nom" required>

                    <input type="text" class="form-control"  placeholder="username" name="username" required>

                    <input type="password" class="form-control"  placeholder="Password" name="password" required>

                    <input type="submit" name="enregistrer" class="btn btn-success" value="s'enregistrer" > 

                    <p class="text-center"><a href="connexion.php">déja un compte ? se connecter</a></p>
                </form>
            </div>

        </div>


    </body>
</html>


