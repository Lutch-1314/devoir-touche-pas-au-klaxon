<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\View;
use App\Models\User;

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
    public function index(): void
    {
        Session::requireAdmin();

        View::render('admin/index');
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

        View::render('admin/users', [
            'users' => $users
        ]);
    }
}