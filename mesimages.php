<?php
require_once "classes/Image.php";
if (empty($_SESSION['username'])) {
    header("Location: connexion.php");
}

$current_page =  $_SERVER['PHP_SELF'];

$status="";
if(isset($_GET["del"])){
$img = Image::getImage($_GET["del"]);
if(empty($img)) header("Location: mesimages.php");
if($img->getAjouter_par()== $_SESSION["username"]){
    if($img->supprimer())
       $status = "<h1 class=\"bg-succes text-dark p-2\" >l'image a été suprimer avec succes</h1><br>"; 
}
}

$page= 1;
if(isset($_GET['page']) && $_GET['page']>0)
    $page = $_GET['page'];


$photos = Image::getImagesByUser($_SESSION["username"],$page);
$total_pages = Image::getPagesNumber($_SESSION["username"],"utilisateur");

$msg = "";
if (count($photos) == 0) {
    $msg = "<h1 class=\"bg-warning text-dark p-2\" >vous n'avez pas encore téléchargé de photo</h1><br>";
    $msg = $msg . "<a href=\"importer.php\" class=\"btn btn-primary\">importer une nouvelle photo</a>";
}
?>
<html>
    <head>
        <title>Mes images</title>
        <?php include './header.php'; ?>

    <div class="container d-flex flex-lg-wrap justify-content-center align-items-center flex-column" style="margin-top:20px;">
        <?php echo $msg; echo $status;?>
        

        <div class="container d-flex flex-lg-wrap justify-content-center" style="margin-top:20px;">


            <div class="images">

                <?php foreach ($photos as $img) { ?>

                    <div class="card crd" >
                        <img class="card-img-top imsize" src="images/<?php echo $img->getPath(); ?>" alt="<?php echo $img->getTitre(); ?>">
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
                         <em class="card-text">catégorie : <?php echo $img->getCategorie(); ?></em>
                         
                         <a href="photo.php?id=<?php echo $img->getId(); ?>" class="btn btn-primary" style="width: 100%; margin:10px 0px;">Afficher</a>
                         <a href="edit.php?id=<?php echo $img->getId(); ?>" class="btn btn-warning" style="width: 100%; margin-bottom: 10px;">Modifier</a>
                         <a href="mesimages.php?del=<?php echo $img->getId(); ?>" class="btn btn-danger" style="width: 100%">Supprimer</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

                
 <?php
    if(count($photos) > 0) { 
     ($page==1) ? $a="disabled" : $a= "";
     echo '<nav aria-label="Page navigation example">
     <ul class="pagination">
     <li class="page-item '.$a.'"><a class="page-link" href="'.$current_page.'?page='.($page-1).'">Précédent</a></li>';
            
  for($i=1;$i<=$total_pages;$i++)
  {
      ($i==$page) ? $a="active" : $a= "";
   echo  '<li class="page-item '.$a.'"><a class="page-link" href="'.$current_page.'?page='.$i.'">'.$i.'</a></li>';
  }
  
        ($page==$total_pages) ? $a="disabled" : $a= "";
   echo '<li class="page-item '.$a.'"><a class="page-link" href="'.$current_page.'?page='.($page+1).'">Suivant</a></li></ul></nav>'; 
             }

 
             ?>          
    </div>
</body>
</html>
