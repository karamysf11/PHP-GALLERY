<?php
require_once "classes/Image.php";
if (empty($_SESSION['username'])) {
    header("Location: connexion.php");
}

$status="";
$img;
if(isset($_GET["id"])){
$img = Image::getImage($_GET["id"]);
if(empty($img)) header("Location: mesimages.php");
if($img->getAjouter_par()!= $_SESSION["username"] && $_SESSION['type'] != "admin"){
    header("Location: mesimages.php");
}    
}


$msg = "";

if (isset($_POST["titre"]) && isset($_POST["description"]) && isset($_POST["categorie"])) {

    if($_FILES['image']['size'] == 0){
        $img->setTitre($_POST["titre"]);
        $img->setDescription($_POST["description"]);
        $img->setCategorie($_POST['categorie']);
        if ($img->modifier())
            $msg = "l'image : \"" . $_POST["titre"] . "\" bien modifier.";
        else $msg="image dosent inserted in db";
    }
    else {
    
        
     //supprimer old image from server
    $file_pointer = "images/".$img->getPath();    
    unlink($file_pointer);
     
    
    // ajouter nouvell image uploaded to server
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

    else if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {


        $img->setPath($path);
        $img->setTitre($_POST["titre"]);
        $img->setDescription($_POST["description"]);
        $img->setCategorie($_POST['categorie']);
        if ($img->modifier())
            $msg = "l'image : \"" . $_POST["titre"] . "\" bien modifier.";
        else $msg="image dosent inserted in db";
    } else {
        $msg = "image n'est pas envoyer";
    }
    }
}
?>

<html>
    <head>
        <title>Modifier</title>
        <?php
        include './header.php';
        ?>



    <div class="container d-flex flex-lg-wrap justify-content-center">
        <h1><?php echo $msg; ?></h1>


        <div class="container d-flex justify-content-center">

            <form  enctype="multipart/form-data" action="edit.php?id=<?php echo $_GET["id"];?>" method="POST" class="frm bg-light">
                <h2 class="text-center">Modifier une image</h2>       

                <input type="text" class="form-control"  placeholder="titre" name="titre" required value="<?php echo $img->getTitre() ?>">

                <textarea class="form-control" maxlength="300"  placeholder="description" name="description"><?php echo $img->getDescription() ?></textarea>

                <select class="form-select" name="categorie" aria-label="Default select example">
                    <option selected disabled>choisi la catégorie</option>
                    <option <?php if ($img->getCategorie() == "chats") echo "selected"; ?> value="chats">chats</option>
                    <option <?php if ($img->getCategorie() == "sport") echo "selected"; ?> value="sport">sport</option>
                    <option <?php if ($img->getCategorie() == "nature") echo "selected"; ?> value="nature">nature</option>
                    <option <?php if ($img->getCategorie() == "été") echo "selected"; ?> value="été">été</option>
                    <option <?php if ($img->getCategorie() == "animaux") echo "selected"; ?> value="animaux">animaux</option>
                    <option <?php if ($img->getCategorie() == "véhicule") echo "selected"; ?> value="véhicule">véhicule</option>
                    <option <?php if ($img->getCategorie() == "architecture") echo "selected"; ?> value="architecture">architecture</option>
                    <option <?php if ($img->getCategorie() == "cuisine") echo "selected"; ?> value="cuisine">cuisine</option>
                </select>
                <br>

                changer l'image est optionelle<input type="file" accept="image/png, image/jpeg" class="form-control"  name="image">

                <input type="submit" name="envoyer" class="btn btn-success" value="Modifier" > 


            </form>
        </div>

    </div>

</body>
</html>


