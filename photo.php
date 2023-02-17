<?php
require_once "classes/Image.php";
require_once "classes/Commentaire.php";
if (isset($_GET['id']))
    $id = $_GET['id'];

$msg="";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["comment"])) {
 if(empty($_SESSION["username"])) header("Location: connexion.php");
    $comment = new Commentaire();
    $comment->setImageID($id);
    $comment->setText($_POST["comment"]);
    $comment->setUtilisateur($_SESSION["username"]);

    if ($comment->ajouterComment()=== true)
        $msg = "votre commentaire bien envoyer";
    else
        $msg = $comment->ajouterComment();
}

$img = Image::getImage($id);

if ($img == false) {
    header("Location: index.php");
}


?>

<html>
    <head>
        <title><?php echo $img->getTitre(); ?></title>
        <?php include './header.php'; ?>

    <div class="container d-flex flex-lg-wrap justify-content-center align-items-center flex-column" style="margin-top:20px;">

        <div class="card img" >
            <img class="card-img-top" src="images/<?php echo $img->getPath(); ?>" alt="<?php echo $img->getTitre(); ?>">
            <div class="card-body">
                <h2 class="card-title"><?php echo $img->getTitre(); ?></h2>
                <p class="card-text">
                    <?php
                    if (strlen($img->getDescription()) > 0)
                        echo $img->getDescription();
                    else
                        echo "Pas de description";
                    ?>

                </p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <h5 class="card-text desc">Ajouté par : <?php echo $img->getAjouter_par(); ?></h5>
                    </li>
                    <li class="list-group-item">
                        <h6 class="card-text desc">impoté à : <?php echo $img->getCreated_at(); ?></h6>
                    </li>
                    <li class="list-group-item">
                        <h6 class="card-text desc">modifié à : <?php echo $img->getUpdated_at(); ?></h6>
                    </li>
                </ul>
                <em class="card-text ms-3">catégorie : <?php echo $img->getCategorie(); ?></em>
                <a href="images/<?php echo $img->getPath(); ?>" class="btn btn-primary" style="width: 100%" download>Télécharger</a>
            </div>
        </div>

        <div class="img">
           
            <h1>Ajouter un commentaire : </h1>
            <form action="photo.php?id=<?php echo $img->getId(); ?>" method="POST"  class="bg-light p-3">
       
        <textarea class="form-control m-1" maxlength="300"  placeholder="Commentaire..." name="comment"></textarea>
        <input type="submit" name="ajouter" class="btn btn-success m-1" value="Ajouter" style="width: 100%"> 

                
                
            </form>
            
            
            
            <h1>Commentaires : </h1>

<?php 
                    foreach ($img->getComments() as $cmt) {
?>
            <div class="card ">
                <div class="card-header d-flex justify-content-between ">
                    <span>Ajouté par : <b><?php echo $cmt->getUtilisateur(); ?></b></span><i> Date : <b><?php echo $cmt->getCreated_at();  ?></b></i>
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p style="white-space: pre-line"><?php echo $cmt->getText();  ?></p>
                    </blockquote>
                </div>
            </div>
                    <?php }  ?>


        </div>
    </div>
</body>
</html>