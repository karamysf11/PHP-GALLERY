<?php
class Commentaire{
  private $id;
  private $text;
  private $imageID;
  private $utilisateur;
  private $created_at;
  
  
  
  
  public function __construct() {
      
  }
  
  
  // static function pour recupuré tous les comentaires d'une image
  public static function getComments($image) {
       $comments = array();
        try {
            $stmt = $GLOBALS['conn']->prepare("select * from commentaires where image = :image");
            $stmt->bindParam(':image', $image);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $tmp = new Commentaire();
                $tmp->setId($row["id"]);
                $tmp->setText($row["commentaire"]);
                $tmp->setUtilisateur($row["utilisateur"]);
                $tmp->setImageID($row["image"]);
                $tmp->setCreated_at($row["created_at"]);
                $comments[] = $tmp;
            }

            return $comments;
        } catch (PDOException $e) {
            return false;
        }
  }
  
  // enregistré le commentaire (objet actuel $this) à la base de donnés
  public function ajouterComment(){
        try {
            $stmt = $GLOBALS['conn']->prepare("INSERT INTO commentaires (commentaire,utilisateur, image) VALUES (:comment, :utilisateur, :image)");
        
            $stmt->bindParam(':utilisateur', $this->utilisateur);
            $stmt->bindParam(':comment', $this->text);
            $stmt->bindParam(':image', $this->imageID);

            if ($stmt->execute() == 1)
                return true;
        } catch (PDOException $e) {
            return $e;
        }
  }

  public function getId() {
      return $this->id;
  }

  public function getText() {
      return $this->text;
  }

  public function getUtilisateur() {
      return $this->utilisateur;
  }

  public function getCreated_at() {
      return $this->created_at;
  }

  public function setId($id): void {
      $this->id = $id;
  }

  public function setText($text): void {
      $this->text = $text;
  }

  public function setUtilisateur($utilisateur): void {
      $this->utilisateur = $utilisateur;
  }

  public function setCreated_at($created_at): void {
      $this->created_at = $created_at;
  }

  public function getImageID() {
      return $this->imageID;
  }

  public function setImageID($imageID): void {
      $this->imageID = $imageID;
  }


}
