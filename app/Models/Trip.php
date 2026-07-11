<?php

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Modèle permettant de gérer les trajets.
 */
class Trip
{
    /**
     * Récupère tous les trajets.
     *
     * @return array
     */
    public static function getAll(): array
    {
        $pdo = Database::getConnection();

        $sql = "
        SELECT
            t.id_trajet,
            ad.ville AS ville_depart,
            aa.ville AS ville_arrivee,
            t.date_heure_depart,
            t.date_heure_arrivee,
            t.places_totales,
            t.places_disponibles,
            u.nom,
            u.prenom
        FROM trajet t

        JOIN agence ad
            ON ad.id_agence = t.id_agence_depart

        JOIN agence aa
            ON aa.id_agence = t.id_agence_arrivee

        JOIN utilisateur u
            ON u.id_utilisateur = t.id_utilisateur

        ORDER BY t.date_heure_depart
    ";

        return $pdo
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les trajets disponibles.
     *
     * @return array
     */
    public static function getTrajetsDisponibles(): array
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT 
                t.id_trajet,
                ad.ville AS ville_depart,
                t.date_heure_depart,
                aa.ville AS ville_arrivee,
                t.date_heure_arrivee,
                t.places_disponibles
            FROM trajet t
            INNER JOIN agence ad
                ON t.id_agence_depart = ad.id_agence
            INNER JOIN agence aa
                ON t.id_agence_arrivee = aa.id_agence
            WHERE t.places_disponibles > 0
                AND t.date_heure_depart > NOW()
            ORDER BY t.date_heure_depart ASC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouveau trajet.
     *
     * @param array $trip
     *
     * @return bool
     */
    public static function create(array $trip): bool
    {
        $pdo = Database::getConnection();

        $sql = "
            INSERT INTO trajet
            (
                date_heure_depart,
                date_heure_arrivee,
                places_totales,
                places_disponibles,
                id_utilisateur,
                id_agence_depart,
                id_agence_arrivee
            )
            VALUES
            (
                :date_depart,
                :date_arrivee,
                :places_totales,
                :places_disponibles,
                :id_utilisateur,
                :id_agence_depart,
                :id_agence_arrivee
            )
        ";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute($trip);
    }

    /**
     * Indique si une agence est utilisée par un trajet.
     *
     * @param int $agencyId
     *
     * @return bool
     */
    public static function isAgencyUsed(int $agencyId): bool
    {
        $pdo = Database::getConnection();

        $sql = "
        SELECT 1
        FROM trajet
        WHERE id_agence_depart = :id
           OR id_agence_arrivee = :id
        LIMIT 1
    ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            'id' => $agencyId
        ]);

        return $stmt->fetchColumn() !== false;
    }
}
