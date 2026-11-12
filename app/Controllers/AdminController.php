<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\View;
use App\Models\User;
use App\Models\Agency;
use App\Models\Trip;

/**
 * Contrôleur du tableau de bord administrateur.
 */
class AdminController
{
    /**
     * Affiche le tableau de bord administrateur.
     *
     * @return void
     */
    public function dashboard(): void
    {
        Session::requireAdmin();

        $user = Session::user();

        View::render("admin/dashboard", [
            "user" => $user,
        ]);
    }

    /**
     * Affiche la liste des utilisateurs.
     *
     * @return void
     */
    public function users(): void
    {
        Session::requireAdmin();

        $users = User::getAll();

        View::render("admin/users", [
            "users" => $users,
        ]);
    }

    /**
     * Affiche la liste des agences.
     *
     * @return void
     */
    public function agencies(): void
    {
        Session::requireAdmin();

        $agencies = Agency::getAll();

        View::render("admin/agencies", [
            "agencies" => $agencies,
        ]);
    }

    /**
     * Affiche la liste des trajets.
     *
     * @return void
     */
    public function trips(): void
    {
        Session::requireAdmin();

        $trips = Trip::getAll();

        View::render("admin/trips", [
            "trips" => $trips,
        ]);
    }
}
