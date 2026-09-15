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
     * Affiche les trajets de l'utilisateur connecté.
     * 
     * @return void
     */
    public function myTrips(): void
    {
        Session::requireLogin();

        $trips = Trip::getTripsByUser(
            Session::user()['id']
        );

        View::render('trip/my-trips', [
            'trips' => $trips
        ]);
    }

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

        View::render('trip/form', [
            'title' => 'Créer un trajet',
            'action' => '/trips/create',
            'button' => 'Créer',
            'trip' => [],
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

        $error = $this->validateTrip($_POST);

        if ($error !== null) {

            $this->displayCreateForm(
                $error,
                $_POST
            );

            return;
        }

        $trip = [
            'date_heure_depart' => $dateDepart,
            'date_heure_arrivee' => $dateArrivee,
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
     * Affiche le formulaire de modification d'un trajet.
     *
     * @return void
     */
    public function edit(): void
    {
        Session::requireLogin();

        $user = User::findById(Session::user()['id']);

        $id = (int) ($_GET['id'] ?? 0);

        if (
            !Session::isAdmin()
            && !Trip::belongsToUser($id, Session::user()['id'])
        ) {
            header('Location: /');
            exit;
        }

        $trip = Trip::findById($id);

        if (!$trip) {
            header('Location: /');
            exit;
        }

        $agencies = Agency::getAll();

        View::render('trip/form', [
            'title' => 'Modifier un trajet',
            'action' => '/trips/edit',
            'button' => 'Enregistrer',
            'trip' => $trip,
            'user' => $user,
            'agencies' => $agencies
        ]);
    }
    /**
     * Met à jour un trajet.
     *
     * @return void
     */
    public function update(): void
    {
        Session::requireLogin();

        $id = (int) $_POST['id_trajet'];

        if (
            !Session::isAdmin()
            && !Trip::belongsToUser($id, Session::user()['id'])
        ) {
            header('Location: /');
            exit;
        }

        $idAgenceDepart = (int) $_POST['id_agence_depart'];
        $idAgenceArrivee = (int) $_POST['id_agence_arrivee'];

        $dateDepart = $_POST['date_heure_depart'];
        $dateArrivee = $_POST['date_heure_arrivee'];

        $placesTotales = (int) $_POST['places_totales'];

        $error = $this->validateTrip($_POST);

        if ($error !== null) {

            $trip = Trip::findById($id);

            $user = User::findById(Session::user()['id']);

            $agencies = Agency::getAll();

            View::render('trip/form', [
                'title' => 'Modifier un trajet',
                'action' => '/trips/edit',
                'button' => 'Enregistrer',
                'trip' => $trip,
                'user' => $user,
                'agencies' => $agencies,
                'old' => $_POST,
                'error' => $error
            ]);

            return;
        }
        $trip = [
            'id_trajet' => $id,
            'date_heure_depart' => $dateDepart,
            'date_heure_arrivee' => $dateArrivee,
            'places_totales' => $placesTotales,
            'id_utilisateur' => Session::user()['id'],
            'id_agence_depart' => $idAgenceDepart,
            'id_agence_arrivee' => $idAgenceArrivee
        ];

        Trip::update($trip);

        Session::setFlash(
            'success',
            'Le trajet a été modifié.'
        );

        if (Session::isAdmin()) {

            header('Location: /admin/trips');
        } else {

            header('Location: /trips/my-trips');
        }

        exit;
    }

    /**
     * Supprime un trajet.
     * 
     * @return void
     */
    public function delete(): void
    {
        Session::requireLogin();

        $id = (int) ($_POST['id_trajet'] ?? 0);

        if (
            !Session::isAdmin()
            && !Trip::belongsToUser($id, Session::user()['id'])
        ) {

            header('Location: /');
            exit;
        }

        Trip::delete($id);

        Session::setFlash(
            'success',
            'Trajet supprimé avec succès.'
        );

        if (Session::isAdmin()) {

            header('Location: /admin/trips');
        } else {

            header('Location: /');
        }

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

        View::render('trip/form', [
            'title' => 'Créer un trajet',
            'action' => '/trips/create',
            'button' => 'Créer',
            'trip' => [
                'id_trajet' => '',
                'date_heure_depart' => $old['date_heure_depart'] ?? '',
                'date_heure_arrivee' => $old['date_heure_arrivee'] ?? '',
                'places_totales' => $old['places_totales'] ?? '',
                'id_agence_depart' => $old['id_agence_depart'] ?? '',
                'id_agence_arrivee' => $old['id_agence_arrivee'] ?? ''
            ],
            'user' => $user,
            'agencies' => $agencies,
            'error' => $errorMessage,
            'old' => $old
        ]);
    }

    /**
     * Valide les données d'un trajet.
     *
     * @param array $data
     *
     * @return string|null Message d'erreur ou null si les données sont valides.
     */
    private function validateTrip(array $data): ?string
    {
        $idAgenceDepart = (int) $data['id_agence_depart'];
        $idAgenceArrivee = (int) $data['id_agence_arrivee'];

        $dateDepart = $data['date_heure_depart'];
        $dateArrivee = $data['date_heure_arrivee'];

        $placesTotales = (int) $data['places_totales'];

        if ($idAgenceDepart === $idAgenceArrivee) {
            return 'Les agences de départ et d\'arrivée doivent être différentes.';
        }

        if ($dateArrivee <= $dateDepart) {
            return 'La date d\'arrivée doit être postérieure à la date de départ.';
        }

        if ($dateDepart < date('Y-m-d\TH:i')) {
            return 'La date de départ ne peut pas être dans le passé.';
        }

        if ($placesTotales < 1) {
            return 'Le nombre de places doit être supérieur à 0.';
        }

        return null;
    }
}
