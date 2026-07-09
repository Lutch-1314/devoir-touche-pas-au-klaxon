<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$utilisateur = $_SESSION['utilisateur'] ?? null;

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

            <?php if ($utilisateur && (int) $utilisateur['admin'] === 1): ?>

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

            <?php elseif ($utilisateur): ?>

                <a href="/trips/create">
                    Créer un trajet
                </a>

                <span>
                    <?= htmlspecialchars($utilisateur['prenom']) ?>
                    <?= htmlspecialchars($utilisateur['nom']) ?>
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