<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\View;
use App\Models\Agency;

/**
 * Contrôleur permettant de gérer les agences.
 */
class AgencyController
{
    /**
     * Affiche le formulaire de création d'une agence.
     *
     * @return void
     */
    public function create(): void
    {
        Session::requireAdmin();

        View::render('agencies/create');
    }

    /**
     * Enregistre une nouvelle agence.
     *
     * @return void
     */
    public function store(): void
    {
        Session::requireAdmin();

        $ville = trim($_POST['ville']);

        if ($ville === '') {

            View::render('agencies/create', [
                'error' => 'Veuillez saisir une ville.'
            ]);

            return;
        }

        Agency::create([
            'ville' => $ville
        ]);

        Session::setFlash('Agence créée avec succès.');

        header('Location: /admin/agencies');
        exit;
    }
}
