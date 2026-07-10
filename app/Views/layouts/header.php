<?php

use App\Core\Session;

$currentUser = Session::user();

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
            <?php if (Session::isAdmin()): ?>

                <a href="/admin">
                    Touche Pas Au Klaxon
                </a>

            <?php else: ?>

                <a href="/">
                    Touche Pas Au Klaxon
                </a>

            <?php endif; ?>
        </div>

        <nav>

            <?php if (Session::isAdmin()): ?>

                <a href="/admin/users">
                    Utilisateurs
                </a>

                <a href="/admin/agencies">
                    Agences
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
                    <?= htmlspecialchars($currentUser['prenom']) ?>
                    <?= htmlspecialchars($currentUser['nom']) ?>
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

    <main>