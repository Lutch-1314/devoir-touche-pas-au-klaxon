<?php

use App\Core\Session;

if ($flash): ?>

    <p class="<?= htmlspecialchars($flash['type']) ?>">
        <?= htmlspecialchars($flash['message']) ?>
    </p>

<?php endif; ?>

<h1>Trajets disponibles</h1>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Départ</th>
            <th>Arrivée</th>
            <th>Départ le</th>
            <th>Arrivée le</th>
            <th>Places disponibles</th>

            <?php if (Session::isLogged()): ?>

                <th>Conducteur</th>
                <th>Informations</th>
                <th>Actions</th>

            <?php endif; ?>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($trips as $trip): ?>

            <tr>
                <td><?= htmlspecialchars($trip['ville_depart']) ?></td>
                <td><?= htmlspecialchars($trip['ville_arrivee']) ?></td>
                <td><?= htmlspecialchars($trip['date_heure_depart']) ?></td>
                <td><?= htmlspecialchars($trip['date_heure_arrivee']) ?></td>
                <td><?= htmlspecialchars($trip['places_disponibles']) ?></td>

                <?php if (Session::isLogged()): ?>

                    <td><?= htmlspecialchars($trip['prenom'] . ' ' . $trip['nom']) ?></td>

                    <td>
                        <button
                            type="button"
                            class="btn btn-outline-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#tripModal<?= $trip['id_trajet'] ?>">
                            + d'infos
                        </button>

                        <?php require __DIR__ . '/trip/info-modal.php'; ?>
                    </td>

                    <td>
                        <?php if (
                            Session::isLogged()
                            && $trip['id_utilisateur'] == Session::user()['id']
                        ): ?>

                            <button
                                type="button"
                                onclick="window.location.href='/trips/edit?id=<?= $trip['id_trajet'] ?>'">
                                Modifier
                            </button>

                            <form
                                action="/trips/delete"
                                method="POST">

                                <input
                                    type="hidden"
                                    name="id_trajet"
                                    value="<?= $trip['id_trajet'] ?>">

                                <button
                                    type="submit"
                                    onclick="return confirm('Supprimer ce trajet ?')">
                                    Supprimer
                                </button>

                            </form>

                        <?php endif; ?>
                    </td>
                <?php endif; ?>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>