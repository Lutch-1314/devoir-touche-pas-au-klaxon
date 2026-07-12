<?php

$old = $old ?? [];

?>

<h1>Créer un trajet</h1>

<?php if (isset($error)): ?>

    <p>
        <?= htmlspecialchars($error) ?>
    </p>

<?php endif; ?>

<form action="/trips/create" method="POST">

    <h2>Informations utilisateur</h2>

    <div>
        <label for="prenom">Prénom</label>
        <input
            type="text"
            id="prenom"
            value="<?= htmlspecialchars($user['prenom']) ?>"
            readonly>
    </div>

    <div>
        <label for="nom">Nom</label>
        <input
            type="text"
            id="nom"
            value="<?= htmlspecialchars($user['nom']) ?>"
            readonly>
    </div>

    <div>
        <label for="email">Adresse e-mail</label>
        <input
            type="email"
            id="email"
            value="<?= htmlspecialchars($user['email']) ?>"
            readonly>
    </div>

    <div>
        <label for="telephone">Téléphone</label>
        <input
            type="text"
            id="telephone"
            value="<?= htmlspecialchars($user['telephone']) ?>"
            readonly>
    </div>


    <h2>Informations du trajet</h2>

    <div>
        <label for="id_agence_depart">
            Agence de départ
        </label>

        <select
            name="id_agence_depart"
            id="id_agence_depart"
            required>

            <option value="">
                Choisir une agence
            </option>

            <?php foreach ($agencies as $agency): ?>

                <option
                    value="<?= $agency['id_agence'] ?>"
                    <?= (($old['id_agence_depart'] ?? '') == $agency['id_agence']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($agency['ville']) ?>
                </option>

            <?php endforeach; ?>

        </select>
    </div>


    <div>
        <label for="id_agence_arrivee">
            Agence d'arrivée
        </label>

        <select
            name="id_agence_arrivee"
            id="id_agence_arrivee"
            required>

            <option value="">
                Choisir une agence
            </option>

            <?php foreach ($agencies as $agency): ?>

                <option
                    value="<?= $agency['id_agence'] ?>"
                    <?= (($old['id_agence_arrivee'] ?? '') == $agency['id_agence']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($agency['ville']) ?>
                </option>

            <?php endforeach; ?>

        </select>
    </div>


    <div>
        <label for="date_heure_depart">
            Date et heure de départ
        </label>

        <input
            type="datetime-local"
            id="date_heure_depart"
            name="date_heure_depart"
            value="<?= htmlspecialchars($old['date_heure_depart'] ?? '') ?>"
            min="<?= date('Y-m-d\TH:i') ?>"
            required>
    </div>


    <div>
        <label for="date_heure_arrivee">
            Date et heure d'arrivée
        </label>

        <input
            type="datetime-local"
            id="date_heure_arrivee"
            name="date_heure_arrivee"
            value="<?= htmlspecialchars($old['date_heure_arrivee'] ?? '') ?>"
            required>
    </div>


    <div>
        <label for="places_totales">
            Nombre de places
        </label>

        <input
            type="number"
            id="places_totales"
            name="places_totales"
            min="1"
            value="<?= htmlspecialchars($old['places_totales'] ?? '') ?>"
            required>
    </div>


    <button type="submit">
        Créer le trajet
    </button>

</form>