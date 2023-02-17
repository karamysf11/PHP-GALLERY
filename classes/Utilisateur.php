<?php

require __DIR__ . '/../config/db.php';

class Utilisateur {

    private $username;
    private $password;
    private $nom;
    private $type;

    public function __construct() {
        
    }
// l'enregistrement de utilisateur à la base de donnés;
    public function enregistrer() {


        try {
            $stmt = $GLOBALS['conn']->prepare("INSERT INTO utilisateurs (username, password, nom) VALUES (:username, :password, :nom)");
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':nom', $this->nom);
            if ($stmt->execute() == 1)
                return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // la connexion de user (objet actuel ) et creation de session
    public function connecter() {


        $stmt = $GLOBALS['conn']->prepare("select nom,username,type from utilisateurs where username = :username and password= :password");
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);

        $stmt->execute();
        $row = $stmt->fetch();

        if ($row != false) {

            $this->nom = $row["nom"];
            $this->type = $row["type"];

            session_start();

            $_SESSION['username'] = $this->username;

            $_SESSION['name'] = $this->nom;

            $_SESSION['type'] = $this->type;

            return true;
        } else
            return false;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom): void {
        $this->nom = $nom;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username): void {
        $this->username = $username;
    }

    public function setPassword($password): void {
        $this->password = $password;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type): void {
        $this->type = $type;
    }

}
