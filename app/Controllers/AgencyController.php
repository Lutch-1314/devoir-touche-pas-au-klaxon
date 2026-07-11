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

        View::render('agencies/form', [
            'title' => 'Créer une agence',
            'action' => '/agencies/create',
            'button' => 'Créer',
            'agency' => [
                'id_agence' => '',
                'ville' => ''
            ]
        ]);
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

    /**
     * Affiche le formulaire de modification d'une agence.
     *
     * @return void
     */
    public function edit(): void
    {
        Session::requireAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        $agency = Agency::findById($id);

        if (!$agency) {
            header('Location: /admin/agencies');
            exit;
        }

        View::render('agencies/form', [
            'title' => 'Modifier une agence',
            'action' => '/agencies/edit',
            'button' => 'Enregistrer',
            'agency' => $agency
        ]);
    }

    /**
     * Met à jour une agence.
     *
     * @return void
     */
    public function update(): void
    {
        Session::requireAdmin();

        $agency = [
            'id_agence' => (int) $_POST['id_agence'],
            'ville' => trim($_POST['ville'])
        ];

        if ($agency['ville'] === '') {

            View::render('agencies/form', [
                'title' => 'Modifier une agence',
                'action' => '/agencies/edit',
                'button' => 'Enregistrer',
                'agency' => $agency,
                'error' => 'Veuillez saisir une ville.'
            ]);

            return;
        }

        Agency::update($agency);

        Session::setFlash('Agence modifiée avec succès.');

        header('Location: /admin/agencies');
        exit;
    }
}
