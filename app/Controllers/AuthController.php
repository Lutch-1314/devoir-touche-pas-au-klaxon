<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Session;
use App\Models\User;

/**
 * Contrôleur gérant l'authentification.
 */
class AuthController
{
    /**
     * Affiche le formulaire de connexion.
     *
     * @return void
     */
    public function login(): void
    {
        View::render('login');
    }

    /**
     * Traite la connexion.
     *
     * @return void
     */
    public function authenticate(): void
    {
        $email = trim($_POST['email']);
        $motDePasse = $_POST['mot_de_passe'];

        $user = User::findByEmail($email);

        if (!$user || $motDePasse !== $user['mot_de_passe']) {

            View::render('login', [
                'error' => 'Adresse e-mail ou mot de passe incorrect.'
            ]);

            return;
        }

        Session::login($user);

        header('Location: /');
        exit;
    }

    /**
     * Déconnecte l'utilisateur.
     *
     * @return void
     */
    public function logout(): void
    {
        Session::logout();

        header('Location: /');
        exit;
    }
}
