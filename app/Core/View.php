<?php

namespace App\Core;

/**
 * Classe permettant d'afficher les vues.
 */
class View
{
    /**
     * Affiche une vue avec son header et son footer.
     *
     * @param string $view Nom de la vue.
     * @param array $data Données transmises à la vue.
     *
     * @return void
     */
    public static function render(string $view, array $data = []): void
    {
        extract($data);

        require APP_PATH . '/Views/layouts/header.php';

        require APP_PATH . '/Views/' . $view . '.php';

        require APP_PATH . '/Views/layouts/footer.php';
    }
}
