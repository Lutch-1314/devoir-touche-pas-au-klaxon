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

        $user = User::findById(Session::user()["id"]);

        $agencies = Agency::getAll();

        View::render("trip/form", [
            "title" => "Créer un trajet",
            "action" => "/trips/create",
            "button" => "Créer le trajet",
            "trip" => [],
            "user" => $user,
            "agencies" => $agencies,
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

        $idAgenceDepart = (int) $_POST["id_agence_depart"];
        $idAgenceArrivee = (int) $_POST["id_agence_arrivee"];

        $dateDepart = $_POST["date_heure_depart"];
        $dateArrivee = $_POST["date_heure_arrivee"];

        $placesTotales = (int) $_POST["places_totales"];

        $error = $this->validateTrip($_POST);

        if ($error !== null) {
            Session::setFlash("error", $error);

            $this->displayCreateForm($_POST);

            return;
        }

        $trip = [
            "date_heure_depart" => $dateDepart,
            "date_heure_arrivee" => $dateArrivee,
            "places_totales" => $placesTotales,
            "places_disponibles" => $placesTotales,
            "id_utilisateur" => Session::user()["id"],
            "id_agence_depart" => $idAgenceDepart,
            "id_agence_arrivee" => $idAgenceArrivee,
        ];

        Trip::create($trip);

        Session::setFlash("success", "Trajet créé avec succès !");

        header("Location: /");
        exit();
    }

    /**
     * Affiche le formulaire de modification d'un trajet.
     *
     * @return void
     */
    public function edit(): void
    {
        Session::requireLogin();

        $user = User::findById(Session::user()["id"]);

        $id = (int) ($_GET["id"] ?? 0);

        if (!Session::isAdmin() && !Trip::belongsToUser($id, Session::user()["id"])) {
            header("Location: /");
            exit();
        }

        $trip = Trip::findById($id);

        if (!$trip) {
            header("Location: /");
            exit();
        }

        $agencies = Agency::getAll();

        View::render("trip/form", [
            "title" => "Modifier un trajet",
            "action" => "/trips/edit",
            "button" => "Enregistrer",
            "trip" => $trip,
            "user" => $user,
            "agencies" => $agencies,
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

        $id = (int) $_POST["id_trajet"];

        if (!Session::isAdmin() && !Trip::belongsToUser($id, Session::user()["id"])) {
            header("Location: /");
            exit();
        }

        // Récupération du trajet actuel
        $currentTrip = Trip::findById($id);

        if (!$currentTrip) {
            header("Location: /");
            exit();
        }

        // Calcul des places déjà occupées
        $placesOccupees = $currentTrip["places_totales"] - $currentTrip["places_disponibles"];

        $idAgenceDepart = (int) $_POST["id_agence_depart"];
        $idAgenceArrivee = (int) $_POST["id_agence_arrivee"];

        $dateDepart = $_POST["date_heure_depart"];
        $dateArrivee = $_POST["date_heure_arrivee"];

        $placesTotales = (int) $_POST["places_totales"];

        // Validation des données du formulaire
        $error = $this->validateTrip($_POST);

        // Vérification de la capacité restante
        if ($error === null && $placesTotales < $placesOccupees) {
            Session::setFlash(
                "error",
                "Le nombre total de places ne peut pas être inférieur au nombre de places déjà occupées.",
            );

            header("Location: /");
            exit();
        }

        // Calcul des nouvelles places disponibles
        $placesDisponibles = $placesTotales - $placesOccupees;

        if ($error !== null) {
            $trip = Trip::findById($id);

            $user = User::findById(Session::user()["id"]);

            $agencies = Agency::getAll();

            View::render("trip/form", [
                "title" => "Modifier un trajet",
                "action" => "/trips/edit",
                "button" => "Enregistrer",
                "trip" => $trip,
                "user" => $user,
                "agencies" => $agencies,
                "old" => $_POST,
                "error" => $error,
            ]);

            return;
        }
        $trip = [
            "id_trajet" => $id,
            "date_heure_depart" => $dateDepart,
            "date_heure_arrivee" => $dateArrivee,
            "places_totales" => $placesTotales,
            "places_disponibles" => $placesDisponibles,
            "id_utilisateur" => Session::user()["id"],
            "id_agence_depart" => $idAgenceDepart,
            "id_agence_arrivee" => $idAgenceArrivee,
        ];

        Trip::update($trip);

        Session::setFlash("success", "Le trajet a été modifié.");

        if (Session::isAdmin()) {
            header("Location: /admin/trips");
        } else {
            header("Location: /");
        }

        exit();
    }

    /**
     * Supprime un trajet.
     *
     * @return void
     */
    public function delete(): void
    {
        Session::requireLogin();

        $id = (int) ($_POST["id_trajet"] ?? 0);

        if (!Session::isAdmin() && !Trip::belongsToUser($id, Session::user()["id"])) {
            header("Location: /");
            exit();
        }

        Trip::delete($id);

        Session::setFlash("success", "Trajet supprimé avec succès.");

        if (Session::isAdmin()) {
            header("Location: /admin/trips");
        } else {
            header("Location: /");
        }

        exit();
    }

    /**
     * Affiche le formulaire de création d'un trajet.
     *
     * @param array $old Anciennes valeurs du formulaire en cas d'erreur.
     *
     * @return void
     */
    private function displayCreateForm(array $old = []): void
    {
        $user = User::findById(Session::user()["id"]);

        $agencies = Agency::getAll();

        View::render("trip/form", [
            "title" => "Créer un trajet",
            "action" => "/trips/create",
            "button" => "Créer",
            "trip" => [
                "id_trajet" => "",
                "date_heure_depart" => $old["date_heure_depart"] ?? "",
                "date_heure_arrivee" => $old["date_heure_arrivee"] ?? "",
                "places_totales" => $old["places_totales"] ?? "",
                "id_agence_depart" => $old["id_agence_depart"] ?? "",
                "id_agence_arrivee" => $old["id_agence_arrivee"] ?? "",
            ],
            "user" => $user,
            "agencies" => $agencies,
            "old" => $old,
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
        $idAgenceDepart = (int) $data["id_agence_depart"];
        $idAgenceArrivee = (int) $data["id_agence_arrivee"];

        $dateDepart = $data["date_heure_depart"];
        $dateArrivee = $data["date_heure_arrivee"];

        $placesTotales = (int) $data["places_totales"];

        if ($idAgenceDepart === $idAgenceArrivee) {
            return 'Les agences de départ et d\'arrivée doivent être différentes.';
        }

        if ($dateArrivee <= $dateDepart) {
            return 'La date d\'arrivée doit être postérieure à la date de départ.';
        }

        if ($dateDepart < date("Y-m-d\TH:i")) {
            return "La date de départ ne peut pas être dans le passé.";
        }

        if ($placesTotales < 1) {
            return "Le nombre de places doit être supérieur à 0.";
        }

        return null;
    }
}
