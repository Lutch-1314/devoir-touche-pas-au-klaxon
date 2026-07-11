<?php

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Modèle permettant de gérer les agences.
 */
class Agency
{
    /**
     * Récupère toutes les agences.
     *
     * @return array
     */
    public static function getAll(): array
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT
                id_agence,
                ville
            FROM agence
            ORDER BY ville
        ";

        $stmt = $pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crée une nouvelle agence.
     *
     * @param array $agency
     *
     * @return void
     */
    public static function create(array $agency): void
    {
        $pdo = Database::getConnection();

        $sql = "
        INSERT INTO agence (
            ville
        )
        VALUES (
            :ville
        )
    ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            'ville' => $agency['ville']
        ]);
    }
}
