<?php

use App\Core\Session;

$user = Session::user();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Touche Pas Au Klaxon</title>
</head>

<body>

    <header>

        <div>
            <a href="/">
                Touche Pas Au Klaxon
            </a>
        </div>

        <nav>

            <?php if (Session::isAdmin()): ?>

                <a href="/admin">
                    Tableau de bord
                </a>

                <a href="/admin/users">
                    Utilisateurs
                </a>

                <a href="/admin/trips">
                    Trajets
                </a>

                <a href="/logout">
                    Déconnexion
                </a>

            <?php elseif (Session::isLogged()): ?>

                <a href="/trips/create">
                    Créer un trajet
                </a>

                <span>
                    <?= htmlspecialchars($user['prenom']) ?>
                    <?= htmlspecialchars($user['nom']) ?>
                </span>

                <a href="/logout">
                    Déconnexion
                </a>

            <?php else: ?>

                <a href="/login">
                    Connexion
                </a>

            <?php endif; ?>

        </nav>
    </header>