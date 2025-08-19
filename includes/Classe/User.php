<?php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getUserByPseudo($pseudo)
    {
        // Vérifie si le pseudo existe et récupère les informations utilisateur
        $query = "SELECT * FROM utilisateur WHERE nom_utilisateur = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$pseudo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($pseudo, $mail, $password)
    {
        // Crée un nouvel utilisateur
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO utilisateur (nom_utilisateur, email, mot_de_passe) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$pseudo, $mail, $hashed_password]);

        return $this->pdo->lastInsertId();
    }

    public function getUserPdo($pseudo)
    {
        return $this->pdo;
    } //sert à rien

}
