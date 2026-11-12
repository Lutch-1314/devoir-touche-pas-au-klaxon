<?php
/** @var array $user */
?>

<h1>Administration</h1>

<p>
    Bienvenue,
    <?= htmlspecialchars($user["prenom"]) ?>
    <?= htmlspecialchars($user["nom"]) ?>.
</p>

<section class="mb-3">

    <h2>Utilisateurs</h2>

    <p>
        Consulter la liste des utilisateurs de l'application.
    </p>

    <a href="/admin/users">
        Voir les utilisateurs
    </a>

</section>

<section class="mb-3">

    <h2>Agences</h2>

    <p>
        Ajouter, modifier ou supprimer une agence.
    </p>

    <a href="/admin/agencies">
        Gérer les agences
    </a>

</section>


<section class="mb-3">

    <h2>Trajets</h2>

    <p>
        Consulter les trajets et supprimer un trajet.
    </p>

    <a href="/admin/trips">
        Voir les trajets
    </a>

</section>
