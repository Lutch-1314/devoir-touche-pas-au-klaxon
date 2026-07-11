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

    /**
     * Recherche une agence par son identifiant.
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
        FROM agence
        WHERE id_agence = :id
    ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Met à jour une agence.
     *
     * @param array $agency
     *
     * @return void
     */
    public static function update(array $agency): void
    {
        $pdo = Database::getConnection();

        $sql = "
        UPDATE agence
        SET ville = :ville
        WHERE id_agence = :id
    ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            'ville' => $agency['ville'],
            'id' => $agency['id_agence']
        ]);
    }

    /**
     * Supprime une agence.
     *
     * @param int $id
     *
     * @return void
     */
    public static function delete(int $id): void
    {
        $pdo = Database::getConnection();

        $sql = "
        DELETE FROM agence
        WHERE id_agence = :id
    ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);
    }
}
