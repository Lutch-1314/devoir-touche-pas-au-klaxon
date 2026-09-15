<?php

use App\Core\Session;

$flash = Session::getFlash();

$currentUser = Session::user();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Touche Pas Au Klaxon</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <header class="border-bottom border-dark">

        <nav class="navbar navbar-expand-lg">

            <div class="container-fluid">

                <?php if (Session::isAdmin()): ?>

                    <a class="navbar-brand" href="/admin">
                        Touche pas au klaxon
                    </a>

                <?php else: ?>

                    <a class="navbar-brand" href="/">
                        Touche Pas Au Klaxon
                    </a>

                <?php endif; ?>

                <ul class="navbar-nav ms-auto d-flex align-items-center gap-3">

                    <?php if (Session::isAdmin()): ?>

                        <li class="nav-item">
                            <a class="btn btn-primary" href="/admin/users">
                                Utilisateurs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="/admin/agencies">
                                Agences
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="/admin/trips">
                                Trajets
                            </a>
                        </li>
                        <li class="nav-item">
                            Bonjour <?= htmlspecialchars($currentUser['prenom']) ?> <?= htmlspecialchars($currentUser['nom']) ?>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-dark" href="/logout">
                                Déconnexion
                            </a>
                        </li>


                    <?php elseif (Session::isLogged()): ?>

                        <li class="nav-item">
                            <a class="btn btn-primary" href="/trips/create">
                                Créer un trajet
                            </a>
                        </li>
                        <li class="nav-item">
                            Bonjour <?= htmlspecialchars($currentUser['prenom']) ?> <?= htmlspecialchars($currentUser['nom']) ?>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-dark" href="/logout">
                                Déconnexion
                            </a>
                        </li>

                    <?php else: ?>

                        <li class="nav-item">
                            <a class="nav-link" href="/login">
                                Connexion
                            </a>
                        </li>

                    <?php endif; ?>

                </ul>

            </div>
        </nav>
    </header>

    <?php if ($flash): ?>
        <p class="flash <?= htmlspecialchars($flash['type']) ?>">
            <?= htmlspecialchars($flash['message']) ?>
        </p>
    <?php endif; ?>

    <main class="m-3">