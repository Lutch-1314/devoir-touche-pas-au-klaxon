<?php

namespace App\Controllers;

use App\Core\View;
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

        $utilisateur = User::findByEmail($email);

        if (!$utilisateur || $motDePasse !== $utilisateur['mot_de_passe']) {

            View::render('login', [
                'error' => 'Adresse e-mail ou mot de passe incorrect.'
            ]);

            return;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['utilisateur'] = [
            'id' => $utilisateur['id_utilisateur'],
            'nom' => $utilisateur['nom'],
            'prenom' => $utilisateur['prenom'],
            'admin' => (int) $utilisateur['admin']
        ];

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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        $_SESSION = [];
    
        if (ini_get('session.use_cookies')) {
    
            $params = session_get_cookie_params();
    
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
    
        session_destroy();
    
        header('Location: /');
        exit;
    }
}
