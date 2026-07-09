<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\View;
use App\Models\Trip;

/**
 * Contrôleur de la page d'accueil.
 */
class HomeController
{
    /**
     * Affiche la page d'accueil.
     *
     * @return void
     */
    public function index(): void
    {
        $trajets = Trip::getTrajetsDisponibles();
        $flash = Session::getFlash();

        View::render('home', [
            'trajets' => $trajets,
            'flash' => $flash
        ]);
    }
}