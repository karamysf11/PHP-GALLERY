<?php
require "classes/Image.php";

$current_page = $_SERVER['PHP_SELF'];

if (isset($_GET['c'])) {
    $categorie = $_GET['c'];
    $current_page .= "?c=" . $categorie;
} else if ($_GET['search']) {
    $search = $_GET['search'];
    $current_page .= "?search=" . $search;
} else
    header("Location: index.php");


$status = "";
if (isset($_GET["del"])) {
    $img = Image::getImage($_GET["del"]);
    if (empty($img)) header("Location: index.php");
    if ($img->getAjouter_par() == $_SESSION["username"] || $_SESSION['type'] == "admin") {
        if ($img->supprimer())
            $status = "<h1 class=\"bg-succes text-dark p-2\" >l'image a été suprimer avec succes</h1><br>";
    }
}


$page = 1;
if (isset($_GET['page']) && $_GET['page'] > 0)
    $page = $_GET['page'];

$total_pages = 1;
if (isset($categorie)) {
    $photos = Image::getImagesByCategorie($categorie, $page);
    $total_pages = Image::getPagesNumber($categorie, "categorie");
} else if (isset($search)) {
    $result = Image::searchImages($search, $page);
    $photos = $result['images'];
    $total_pages = $result['total_pages'];
}

$msg = "";
if (count($photos) == 0) {
    $msg = "<h1 class=\"bg-warning text-dark p-2\" >il n y a pas des photos dans cette categorie</h1><br>";
    $msg = $msg . "<a href=\"importer.php\" class=\"btn btn-primary\">importer une nouvelle photo</a>";
}


?>
<html>
<head>
    <title>photos de : <?php echo(isset($categorie) ? $categorie : $search); ?></title>
    <?php include './header.php'; ?>

    <div class="container d-flex flex-lg-wrap justify-content-center align-items-center flex-column"
         style="margin-top:20px;">
        <?php echo $status;
        echo $msg; ?>
        <div class="container d-flex flex-lg-wrap justify-content-center" style="margin-top:20px;">


            <div class="images">

                <?php foreach ($photos as $img) { ?>

                    <div class="card crd">
                        <img class="card-img-top imsize" src="images/<?php echo $img->getPath(); ?>"
                             alt="<?php echo $img->getTitre(); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $img->getTitre(); ?></h5>
                            <p class="card-text desc">
                                <?php
                                if (strlen($img->getDescription()) > 0)
                                    echo $img->getDescription();
                                else
                                    echo "Pas de description";
                                ?>

                            </p>
                            <em class="card-text ">catégorie : <?php echo $img->getCategorie(); ?></em>
                            <a href="photo.php?id=<?php echo $img->getId(); ?>" class="btn btn-primary"
                               style="width: 100%;  margin:10px 0px;">Afficher</a>
                            <?php
                            if (isset($_SESSION['type']) && $_SESSION['type'] == "admin") {
                                ?>
                                <a href="edit.php?id=<?php echo $img->getId(); ?>" class="btn btn-warning"
                                   style="width: 100%; margin-bottom: 10px;">Modifier</a>
                                <a href="<?php echo $current_page . '&del=' . $img->getId(); ?>" class="btn btn-danger"
                                   style="width: 100%">Supprimer</a>
                            <?php } ?>


                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>


        <?php if (count($photos) > 0) {
            ($page == 1) ? $a = "disabled" : $a = "";
            echo '<nav aria-label="Page navigation example">
     <ul class="pagination">
     <li class="page-item ' . $a . '"><a class="page-link" href="' . $current_page . '&page=' . ($page - 1) . '">Précédent</a></li>';

            for ($i = 1; $i <= $total_pages; $i++) {
                ($i == $page) ? $a = "active" : $a = "";
                echo '<li class="page-item ' . $a . '"><a class="page-link" href="' . $current_page . '&page=' . $i . '">' . $i . '</a></li>';
            }

            ($page == $total_pages) ? $a = "disabled" : $a = "";
            echo '<li class="page-item ' . $a . '"><a class="page-link" href="' . $current_page . '&page=' . ($page + 1) . '">Suivant</a></li></ul></nav>';
        }
        ?>

    </div>
    </body>
</html>
