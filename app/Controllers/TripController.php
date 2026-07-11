<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\View;
use App\Models\Agency;
use App\Models\Trip;
use App\Models\User;

/**
 * Contrôleur permettant de gérer les trajets.
 */
class TripController
{
    /**
     * Affiche le formulaire de création d'un trajet.
     *
     * @return void
     */
    public function create(): void
    {
        Session::requireLogin();

        $user = User::findById(Session::user()['id']);

        $agencies = Agency::getAll();

        View::render('trip/create', [
            'user' => $user,
            'agencies' => $agencies
        ]);
    }

    /**
     * Enregistre un nouveau trajet.
     *
     * @return void
     */
    public function store(): void
    {
        Session::requireLogin();

        $idAgenceDepart = (int) $_POST['id_agence_depart'];
        $idAgenceArrivee = (int) $_POST['id_agence_arrivee'];

        $dateDepart = $_POST['date_heure_depart'];
        $dateArrivee = $_POST['date_heure_arrivee'];

        $placesTotales = (int) $_POST['places_totales'];

        $old = [
            'id_agence_depart' => $idAgenceDepart,
            'id_agence_arrivee' => $idAgenceArrivee,
            'date_heure_depart' => $dateDepart,
            'date_heure_arrivee' => $dateArrivee,
            'places_totales' => $placesTotales
        ];

        // Vérification : l'agence de départ et d'arrivée doivent être différentes
        if ($idAgenceDepart === $idAgenceArrivee) {

            $this->displayCreateForm(
                'L\'agence de départ et l\'agence d\'arrivée doivent être différentes.',
                $old
            );

            return;
        }


        // Vérification : l'arrivée doit être après le départ
        if ($dateArrivee <= $dateDepart) {

            $this->displayCreateForm(
                'La date d\'arrivée doit être après la date de départ.',
                $old
            );

            return;
        }


        // Vérification : nombre de places positif
        if ($placesTotales <= 0) {

            $this->displayCreateForm(
                'Le nombre de places doit être supérieur à zéro.',
                $old
            );

            return;
        }


        $trip = [
            'date_depart' => $dateDepart,
            'date_arrivee' => $dateArrivee,
            'places_totales' => $placesTotales,
            'places_disponibles' => $placesTotales,
            'id_utilisateur' => Session::user()['id'],
            'id_agence_depart' => $idAgenceDepart,
            'id_agence_arrivee' => $idAgenceArrivee
        ];


        Trip::create($trip);

        Session::setFlash(
            'success',
            'Trajet créé avec succès !'
        );

        header('Location: /');
        exit;
    }

    /**
     * Affiche le formulaire de création d'un trajet avec un message d'erreur.
     *
     * @param string $errorMessage
     *
     * @return void
     */
    private function displayCreateForm(string $errorMessage, array $old = []): void
    {
        $user = User::findById(Session::user()['id']);

        $agencies = Agency::getAll();

        View::render('trip/create', [
            'user' => $user,
            'agencies' => $agencies,
            'error' => $errorMessage,
            'old' => $old
        ]);
    }
}
