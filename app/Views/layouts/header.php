<?php

use App\Core\Session;

$currentUser = Session::user();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Touche Pas Au Klaxon</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <header>

        <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">

            <div class="container-fluid">

                <?php if (Session::isAdmin()): ?>

                    <a class="navbar-brand" href="/admin">
                        Touche Pas Au Klaxon
                    </a>

                <?php else: ?>

                    <a class="navbar-brand" href="/">
                        Touche Pas Au Klaxon
                    </a>

                <?php endif; ?>

                <ul class="navbar-nav ms-auto">

                    <?php if (Session::isAdmin()): ?>

                        <li class="nav-item">
                            <a class="nav-link" href="/admin/users">
                                Utilisateurs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/agencies">
                                Agences
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/trips">
                                Trajets
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout">
                                Déconnexion
                            </a>
                        </li>


                    <?php elseif (Session::isLogged()): ?>

                        <li class="nav-item">
                            <a class="nav-link" href="/trips/my-trips">
                                Mes trajets
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/trips/create">
                                Créer un trajet
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout">
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

    <main>