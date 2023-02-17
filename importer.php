<?php
require_once "classes/Image.php";
if (empty($_SESSION['username'])) {
    header("Location: connexion.php");
}

$msg = "";

if (isset($_POST["titre"]) && isset($_POST["description"]) && isset($_POST["categorie"]) && $_FILES['image']['size'] > 0) {

    $target_dir = "images/";
    $path = basename($_FILES['image']['name']);
    $target_file = $target_dir . basename($_FILES['image']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (file_exists($target_file)) {
        $msg = "image avec meme nom exist déja";
    }


   else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $msg = "cette format n'est pas accepter";
    }

 else   if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

        $img = new Image();
        $img->setPath($path);
        $img->setTitre($_POST["titre"]);
        $img->setDescription($_POST["description"]);
        $img->setAjouter_par($_SESSION['username']);
        $img->setCategorie($_POST['categorie']);
        if ($img->envoyer())
            $msg = "l'image : \"" . $_POST["titre"] . "\" bien envoyer.";
        else $msg="image dosent inserted in db";
    } else {
        $msg = "image n'est pas envoyer";
    }
}
?>

<html>
    <head>
        <title>importer</title>
        <?php
        include './header.php';
        ?>



    <div class="container d-flex flex-lg-wrap justify-content-center">
        <h1><?php echo $msg; ?></h1>


        <div class="container d-flex justify-content-center">

            <form  enctype="multipart/form-data" action="importer.php" method="POST" class="frm bg-light">
                <h2 class="text-center">importer une image</h2>       

                <input type="text" class="form-control"  placeholder="titre" name="titre" required>

                <textarea class="form-control" maxlength="300"  placeholder="description" name="description"></textarea>

                <select class="form-select" name="categorie" aria-label="Default select example">
                    <option selected disabled>choisi la catégorie</option>
                    <option value="chats">chats</option>
                    <option value="sport">sport</option>
                    <option value="nature">nature</option>
                    <option value="été">été</option>
                    <option value="animaux">animaux</option>
                    <option value="véhicule">véhicule</option>
                    <option value="architecture">architecture</option>
                    <option value="cuisine">cuisine</option>
                </select>

                <input type="file" accept="image/png, image/jpeg" class="form-control"  name="image" required>

                <input type="submit" name="envoyer" class="btn btn-success" value="envoyer" > 


            </form>
        </div>

    </div>

</body>
</html>


