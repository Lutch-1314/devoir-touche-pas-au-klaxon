<?php

namespace App\Core;

/**
 * Classe permettant de gérer la session utilisateur.
 */
class Session
{
    /**
     * Démarre la session si nécessaire.
     *
     * @return void
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Retourne l'utilisateur connecté.
     *
     * @return array|null
     */
    public static function user(): ?array
    {
        self::start();

        return $_SESSION['user'] ?? null;
    }

    /**
     * Indique si un utilisateur est connecté.
     *
     * @return bool
     */
    public static function isLogged(): bool
    {
        return self::user() !== null;
    }

    /**
     * Indique si l'utilisateur connecté est administrateur.
     *
     * @return bool
     */
    public static function isAdmin(): bool
    {
        $user = self::user();

        return $user !== null && (int) $user['admin'] === 1;
    }

    /**
     * Enregistre l'utilisateur en session.
     *
     * @param array $user
     *
     * @return void
     */
    public static function login(array $user): void
    {
        self::start();

        $_SESSION['user'] = [
            'id' => $user['id_utilisateur'],
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'admin' => (int) $user['admin']
        ];
    }

    /**
     * Déconnecte l'utilisateur.
     *
     * @return void
     */
    public static function logout(): void
    {
        self::start();

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
    }

    /**
     * Redirige vers la page de connexion
     * si aucun utilisateur n'est connecté.
     *
     * @return void
     */
    public static function requireLogin(): void
    {
        if (!self::isLogged()) {
            header('Location: /login');
            exit;
        }
    }

    /**
 * Ajoute un message temporaire.
 *
 * @param string $message
 *
 * @return void
 */
public static function setFlash(string $message): void
{
    $_SESSION['flash'] = $message;
}


/**
 * Récupère et supprime un message temporaire.
 *
 * @return string|null
 */
public static function getFlash(): ?string
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }

    $message = $_SESSION['flash'];

    unset($_SESSION['flash']);

    return $message;
}
}
