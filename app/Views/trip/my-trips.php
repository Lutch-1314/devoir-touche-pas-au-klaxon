<?php if ($flash): ?>

    <p class="<?= htmlspecialchars($flash['type']) ?>">
        <?= htmlspecialchars($flash['message']) ?>
    </p>

<?php endif; ?>

<h1>Mes trajets</h1>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Départ</th>
            <th>Arrivée</th>
            <th>Départ le</th>
            <th>Arrivée le</th>
            <th>Places totales</th>
            <th>Places disponibles</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody> 

        <?php foreach ($trips as $trip): ?>

            <tr>
                <td><?= htmlspecialchars($trip['ville_depart']) ?></td>

                <td><?= htmlspecialchars($trip['ville_arrivee']) ?></td>

                <td><?= htmlspecialchars($trip['date_heure_depart']) ?></td>

                <td><?= htmlspecialchars($trip['date_heure_arrivee']) ?></td>

                <td><?= htmlspecialchars($trip['places_totales']) ?></td>

                <td><?= htmlspecialchars($trip['places_disponibles']) ?></td>

                <td>

                    <form
                        action="/trips/delete"
                        method="POST"
                    >

                        <input
                            type="hidden"
                            name="id_trajet"
                            value="<?= $trip['id_trajet'] ?>"
                        >

                        <button
                            type="submit"
                            onclick="return confirm('Supprimer ce trajet ?')"
                        >
                            Supprimer
                        </button>

                    </form>
                </td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>