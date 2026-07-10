<?php

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Modèle permettant de gérer les utilisateurs.
 */
class User
{
    /**
     * Recherche un utilisateur par son adresse e-mail.
     *
     * @param string $email
     *
     * @return array|false
     */
    public static function findByEmail(string $email): array|false
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT *
            FROM utilisateur
            WHERE email = :email
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Recherche un utilisateur par son identifiant.
     *
     * @param int $id
     *
     * @return array|false
     */
    public static function findById(int $id): array|false
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT *
            FROM utilisateur
            WHERE id_utilisateur = :id
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les utilisateurs.
     *
     * @return array
     */
    public static function getAll(): array
    {
        $pdo = Database::getConnection();

        $sql = "
        SELECT
            id_utilisateur,
            nom,
            prenom,
            telephone,
            email,
            admin
        FROM utilisateur
        ORDER BY nom, prenom
    ";

        $stmt = $pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
