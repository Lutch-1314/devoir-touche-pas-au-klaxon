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
}