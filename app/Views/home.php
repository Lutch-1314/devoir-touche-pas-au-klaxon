<h1>Trajets disponibles</h1>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Départ</th>
            <th>Date de départ</th>
            <th>Arrivée</th>
            <th>Date d'arrivée</th>
            <th>Places disponibles</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($trajets as $trajet): ?>

            <tr>
                <td><?= htmlspecialchars($trajet['ville_depart']) ?></td>

                <td><?= htmlspecialchars($trajet['date_heure_depart']) ?></td>

                <td><?= htmlspecialchars($trajet['ville_arrivee']) ?></td>

                <td><?= htmlspecialchars($trajet['date_heure_arrivee']) ?></td>

                <td><?= htmlspecialchars($trajet['places_disponibles']) ?></td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>