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
}