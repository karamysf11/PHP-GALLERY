<?php
require "classes/Utilisateur.php";
require "classes/Image.php";

?>

<html>
    <head>
        <title>Gallery</title>

        <?php include './header.php';?>

    <div class="container d-flex flex-lg-wrap justify-content-center">



        <div class="container d-flex justify-content-center">
            <form action="photos.php" method="GET" class="form-inline search">

                <input type="text" class="form-control rounded-0"  placeholder="chercher une image" name="search" required>
                <input type="submit" class="btn btn-success rounded-0" value="rechercher" > 

            </form>
        </div>

    </div>
    <div class="categories">

        <div class="card crd" >
            <img class="card-img-top imsize" src="images/categories/chats.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">chats</h5>
                <a href="photos.php?c=chats" class="btn btn-primary">Tous les images  (<?php echo Image::countImageByCategorie("chats");?>)</a>
            </div>
        </div>

        <div class="card crd">  
            <img class="card-img-top imsize" src="images/categories/sports.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">sport</h5>
                <a href="photos.php?c=sport" class="btn btn-primary">Tous les images (<?php echo Image::countImageByCategorie("sport");?>)</a>
               
            </div>  
        </div>
            

        <div class="card crd" >
            <img class="card-img-top imsize" src="images/categories/nature.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">nature</h5>
                <a href="photos.php?c=nature" class="btn btn-primary">Tous les images (<?php echo Image::countImageByCategorie("nature");?>)</a>
            </div>
        </div>

        <div class="card crd" >
            <img class="card-img-top imsize" src="images/categories/ete.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">été</h5>
                <a href="photos.php?c=été" class="btn btn-primary">Tous les images (<?php echo Image::countImageByCategorie("été");?>)</a>
            </div>
        </div>

        <div class="card crd" >
            <img class="card-img-top imsize" src="images/categories/animaux.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">animaux</h5>
                <a href="photos.php?c=animaux" class="btn btn-primary">Tous les images (<?php echo Image::countImageByCategorie("animaux");?>)</a>
            </div>
        </div>

        <div class="card crd" >
            <img class="card-img-top imsize" src="images/categories/vehicule.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">véhicule</h5>
                <a href="photos.php?c=véhicule" class="btn btn-primary">Tous les images (<?php echo Image::countImageByCategorie("véhicule");?>)</a>
            </div>
        </div>

        <div class="card crd" >
            <img class="card-img-top imsize" src="images/categories/architecture.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">architecture</h5>
                <a href="photos.php?c=architecture" class="btn btn-primary">Tous les images (<?php echo Image::countImageByCategorie("architecture");?>)</a>
            </div>
        </div>

        <div class="card crd" >
            <img class="card-img-top imsize" src="images/categories/cuisine.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">cuisine</h5>
                <a href="photos.php?c=cuisine" class="btn btn-primary">Tous les images (<?php echo Image::countImageByCategorie("cuisine");?>)</a>
            </div>
        </div>





    </div>

</body>
</html>
