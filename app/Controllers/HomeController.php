<?php

namespace Alnet\DevoirTouchePasAuKlaxon\Controllers;

use Alnet\DevoirTouchePasAuKlaxon\Models\Trajet;

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
        $trajets = Trajet::getTrajetsDisponibles();

        require __DIR__ . '/../Views/home.php';
    }
}