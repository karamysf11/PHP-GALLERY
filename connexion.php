<?php
require "classes/Utilisateur.php";

$msg="";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["password"])) {

    $userLogin = new Utilisateur();
    $userLogin->setUsername($_POST["username"]);
    $userLogin->setPassword(md5($_POST["password"]));

    if ($userLogin->connecter())
        $msg= " connexion avec succes ";
    else
        $msg= "username ou password est erroné";
}
session_start();
if (!empty($_SESSION['username']))
    header("Location: index.php");
?>


<html>
    <head>
        <title>connexion</title>

        <?php
        include './header.php';
        echo $msg;
        ?>

        <div class="container d-flex justify-content-center">
            <form action="connexion.php" method="POST" class="frm bg-light">
                <h2 class="text-center">Se connecter</h2>       
              
                <input type="text" class="form-control"  placeholder="username" name="username" required>
                
                <input type="password" class="form-control"  placeholder="Password" name="password" required>

                <input type="submit" name="connexion" class="btn btn-success" value="connexion" > 

                <p class="text-center"><a href="enregistrer.php">S'enregistrer</a></p>
            </form>
        </div>

    </body>
</html>


