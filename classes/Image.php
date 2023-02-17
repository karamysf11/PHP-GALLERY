<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/Commentaire.php';
session_start();

class Image {

    private $id;
    private $path;
    private $titre;
    private $description;
    private $categorie;
    private $comments = array();
    private $ajouter_par;
    private $created_at;
    private $updated_at;

    public function __construct() {
        
    }

    
    // récupérer le nombre d'images dans une catégorie à partir de la base de données 
    public static function countImageByCategorie($categorie) {

        try {

            $stmt = $GLOBALS['conn']->prepare("SELECT count(id) as c from images where categorie = :param");
            $stmt->bindParam(':param', $categorie);
            $stmt->execute();

            if ($count = $stmt->fetchColumn(0)) {

                return $count;
            } else
                return 0;
        } catch (PDOException $e) {
            return false;
        }
    }


   
    // rechercher dans les images en utilisant le titre et la description et la catégorie
    public static function searchImages($keyword, $page) {

        $qty = 6;
        $start_from_line = ($page - 1) * $qty;

        $search_result = array();
        $images = array();
        try {


            $stmt = $GLOBALS['conn']->prepare("select count(id) from images where titre like '%$keyword%' or description like '%$keyword%' or categorie like '%$keyword%' ");
            $stmt->execute();

            if ($count = $stmt->fetchColumn(0))
                $search_result['total_pages'] = ceil($count / 6);
            else
                $search_result['total_pages'] = 0;



            $stmt = $GLOBALS['conn']->prepare("select * from images where titre like '%$keyword%' or description like '%$keyword%' or categorie like '%$keyword%' order by id desc limit $start_from_line,$qty");
            $stmt->execute();
            while ($row = $stmt->fetch()) {

                $tmp = new Image();
                $tmp->setId($row["id"]);
                $tmp->setTitre($row["titre"]);
                $tmp->setCategorie($row["categorie"]);
                $tmp->setDescription($row["description"]);
                $tmp->setPath($row["path"]);
                $tmp->setAjouter_par($row["utilisateur"]);
                $tmp->setCreated_at($row["created_at"]);
                $tmp->setUpdated_at($row["updated_at"]);

                $images[] = $tmp;
            }

            $search_result['images'] = $images;

            return $search_result;
        } catch (PDOException $e) {
            return false;
        }
    }

  
// obtenir le nombre de pages en calculant la quantité d'image dans la base de données (à utiliser dans la pagination)
    public static function getPagesNumber($param, $type) {

        try {

            $stmt = $GLOBALS['conn']->prepare("SELECT count(id) as c from images where $type = :param");
            $stmt->bindParam(':param', $param);
            $stmt->execute();

            if ($count = $stmt->fetchColumn(0)) {

                return ceil($count / 6);
            } else
                return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    
    // obtenir des images dans une catégorie avec un paramètre de numéro de page
    public static function getImagesByCategorie($categorie, $page) {
        $qty = 6;
        $start_from_line = ($page - 1) * $qty;

        $images = array();
        try {

            $stmt = $GLOBALS['conn']->prepare("select * from images where categorie = :param order by id desc LIMIT $start_from_line, $qty");
            $stmt->bindParam(':param', $categorie);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $tmp = new Image();
                $tmp->setId($row["id"]);
                $tmp->setTitre($row["titre"]);
                $tmp->setCategorie($row["categorie"]);
                $tmp->setDescription($row["description"]);
                $tmp->setPath($row["path"]);
                $tmp->setAjouter_par($row["utilisateur"]);
                $tmp->setCreated_at($row["created_at"]);
                $tmp->setUpdated_at($row["updated_at"]);

                $images[] = $tmp;
            }
            return $images;
        } catch (PDOException $e) {
            return false;
        }
    }

    
// obtenir des images importer par un user avec un paramètre de numéro de page
    public static function getImagesByUser($user, $page) {
        $qty = 6;
        $start_from_line = ($page - 1) * $qty;

        $images = array();
        try {
            $stmt = $GLOBALS['conn']->prepare("select * from images where utilisateur = :param order by id desc LIMIT $start_from_line, $qty ");
            $stmt->bindParam(':param', $user);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $tmp = new Image();
                $tmp->setId($row["id"]);
                $tmp->setTitre($row["titre"]);
                $tmp->setCategorie($row["categorie"]);
                $tmp->setDescription($row["description"]);
                $tmp->setPath($row["path"]);
                $tmp->setAjouter_par($row["utilisateur"]);
                $tmp->setCreated_at($row["created_at"]);
                $tmp->setUpdated_at($row["updated_at"]);

                $images[] = $tmp;
            }

            return $images;
        } catch (PDOException $e) {
            return false;
        }
    }

    
    // pour obtenir un specific image utilisant sa Id
    public static function getImage($id) {
        try {

            $stmt = $GLOBALS['conn']->prepare("select * from images where id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            if ($row = $stmt->fetch()) {
                $tmp = new Image();
                $tmp->setId($row["id"]);
                $tmp->setTitre($row["titre"]);
                $tmp->setCategorie($row["categorie"]);
                $tmp->setDescription($row["description"]);
                $tmp->setPath($row["path"]);
                $tmp->setAjouter_par($row["utilisateur"]);
                $tmp->setCreated_at($row["created_at"]);
                $tmp->setUpdated_at($row["updated_at"]);
                $tmp->setComments(Commentaire::getComments($id));
                return $tmp;
            } else
                return false;
        } catch (PDOException $e) {
            return false;
        }
    }

   
    // pour supprimer l'image de la base de donnés ( l'image supprimer c'est l'objet actul $this)
    public function supprimer() {

        try {
            $stmt = $GLOBALS['conn']->prepare("delete from commentaires where image = :image");
            $stmt->bindParam(':image', $this->id);
            if ($stmt->execute() == 1) {
                $stmt = $GLOBALS['conn']->prepare("delete from images where id = :id");
                $stmt->bindParam(':id', $this->id);
                if ($stmt->execute() == 1) {
                    $file_pointer = __DIR__ . '/../images/' . $this->getPath();
                    unlink($file_pointer);
                }
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    
    // pour modifier l'image (objet actuel $this)
    public function modifier() {
        try {
            $stmt = $GLOBALS['conn']->prepare("update images set titre = :titre, path = :path, description= :description, categorie = :categorie where id = :id");
            $stmt->bindParam(':titre', $this->titre);
            $stmt->bindParam(':path', $this->path);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':categorie', $this->categorie);
            $stmt->bindParam(':id', $this->id);

            if ($stmt->execute() == 1)
                return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    //pour enregistrer la photo (objet actuel) en base de donnés
    public function envoyer() {
        try {
            $stmt = $GLOBALS['conn']->prepare("INSERT INTO images (titre, path, description, utilisateur, categorie) VALUES (:titre, :path, :description, :utilisateur, :categorie)");
            $stmt->bindParam(':titre', $this->titre);
            $stmt->bindParam(':path', $this->path);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':utilisateur', $this->ajouter_par);
            $stmt->bindParam(':categorie', $this->categorie);

            if ($stmt->execute() == 1)
                return true;
        } catch (PDOException $e) {
            return false;
        }
    }

   
    
    
    // getters and setters
    
    public function getId() {
        return $this->id;
    }

    public function getPath() {
        return $this->path;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCategorie() {
        return $this->categorie;
    }

    public function setCategorie($categorie): void {
        $this->categorie = $categorie;
    }

    public function getAjouter_par() {
        return $this->ajouter_par;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setAjouter_par($ajouter_par) {
        $this->ajouter_par = $ajouter_par;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function getCreated_at() {
        return $this->created_at;
    }

    public function getUpdated_at() {
        return $this->updated_at;
    }

    public function setCreated_at($created_at) {
        $this->created_at = $created_at;
    }

    public function setUpdated_at($updated_at) {
        $this->updated_at = $updated_at;
    }

    public function getComments() {
        return $this->comments;
    }

    public function setComments($comments): void {
        $this->comments = $comments;
    }

}
