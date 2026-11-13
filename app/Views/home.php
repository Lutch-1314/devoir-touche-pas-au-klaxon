<?php

use App\Core\Session; 
/** @var array $trips */

?>

<?php if (Session::user()): ?>

    <h1 class="pb-2">Trajets proposés</h1>

<?php else: ?>

    <p class="fs-2">
        Pour obtenir plus d'informations sur un trajet, veuillez vous connecter.
    </p>

<?php endif; ?>

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

            <?php if (Session::isLogged()): ?>

                <th></th>

            <?php endif; ?>
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

                <?php if (Session::isLogged()): ?>

                    <td>
                        <div class="d-flex justify-content-center">
                        <button
                            type="button"
                            class="btn"
                            data-bs-toggle="modal"
                            data-bs-target="#tripModal<?= $trip["id_trajet"] ?>"
                        >
                            <i class="bi bi-eye" aria-hidden="true"></i>
                        </button>

                        <?php require __DIR__ . "/trip/info-modal.php"; ?>

                        <?php if (
                            Session::isLogged() &&
                            $trip["id_utilisateur"] == Session::user()["id"]
                        ): ?>

                            <button
                                type="button"
                                class="btn"
                                onclick="window.location.href='/trips/edit?id=<?= $trip[
                                    "id_trajet"
                                ] ?>'"
                            >
                                <i class="bi bi-pencil-square"></i>
                            </button>

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

                        <?php endif; ?>
                        </div>
                    </td>
                <?php endif; ?>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>
