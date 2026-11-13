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
        View::render("login");
    }

    /**
     * Traite la connexion.
     *
     * @return void
     */
    public function authenticate(): void
    {
        $email = trim($_POST["email"]);
        $motDePasse = $_POST["mot_de_passe"];

        $user = User::findByEmail($email);

        if (!$user || !password_verify($motDePasse, $user["mot_de_passe"])) {
            Session::setFlash("error", "Adresse e-mail ou mot de passe incorrect.");

            header("Location: /login");
            exit();
        }

        // Ne pas conserver le hachage du mot de passe dans la session.
        unset($user["mot_de_passe"]);

        Session::login($user);

        if (Session::isAdmin()) {
            header("Location: /admin");
        } else {
            header("Location: /");
        }

        exit();
    }

    /**
     * Déconnecte l'utilisateur.
     *
     * @return void
     */
    public function logout(): void
    {
        Session::logout();

        header("Location: /");
        exit();
    }
}
