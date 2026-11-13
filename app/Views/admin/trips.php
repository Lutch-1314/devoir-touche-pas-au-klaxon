<?php
/** @var array $trips */
?>

<h1>Liste des trajets</h1>

<table class="table table-striped table-bordered text-center">

    <thead>
        <tr>
            <th>Départ</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Destination</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Places</th>
            <th></th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($trips as $trip): ?>

            <tr>
                <td><?= htmlspecialchars($trip["ville_depart"]) ?></td>

                <?php $depart = new DateTime($trip["date_heure_depart"]); ?>

                <td><?= htmlspecialchars($depart->format("d/m/y")) ?></td>
                <td><?= htmlspecialchars($depart->format("H:i")) ?></td>

                <td><?= htmlspecialchars($trip["ville_arrivee"]) ?></td>

                <?php $arrivee = new DateTime($trip["date_heure_arrivee"]); ?>

                <td><?= htmlspecialchars($arrivee->format("d/m/y")) ?></td>
                <td><?= htmlspecialchars($arrivee->format("H:i")) ?></td>

                <td><?= htmlspecialchars($trip["places_disponibles"]) ?></td>

                <td>
                    <div class="d-flex justify-content-center">

                        <form
                            action="/trips/delete"
                            method="POST">

                            <input
                                type="hidden"
                                name="id_trajet"
                                value="<?= $trip["id_trajet"] ?>">

                            <button
                                type="submit"
                                class="btn"
                                onclick="return confirm('Supprimer ce trajet ?')">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>
