
<?php

$old = $old ?? [];
$trip = $trip ?? [];

$departureAgency = $old["id_agence_depart"] ?? ($trip["id_agence_depart"] ?? "");
$arrivalAgency = $old["id_agence_arrivee"] ?? ($trip["id_agence_arrivee"] ?? "");

$places = $old["places_totales"] ?? ($trip["places_totales"] ?? "");

$departureDate =
    $old["date_heure_depart"] ??
    (!empty($trip["date_heure_depart"])
        ? date("Y-m-d\TH:i", strtotime($trip["date_heure_depart"]))
        : "");

$arrivalDate =
    $old["date_heure_arrivee"] ??
    (!empty($trip["date_heure_arrivee"])
        ? date("Y-m-d\TH:i", strtotime($trip["date_heure_arrivee"]))
        : "");
?>

<h1><?= htmlspecialchars($title) ?></h1>

<form
    action="<?= htmlspecialchars($action) ?>"
    method="POST"
>
    <?php if (!empty($trip["id_trajet"])): ?>
        <input
            type="hidden"
            name="id_trajet"
            value="<?= htmlspecialchars($trip["id_trajet"]) ?>"
        >
    <?php endif; ?>

    <div class="row mb-2 align-items-center">
        <label for="id_agence_depart" class="col-sm-2 col-form-label">
            Agence de départ :
        </label>
        <div class="col-sm-6">
            <select
                name="id_agence_depart"
                id="id_agence_depart"
                required
            >
                <option value="" disabled <?= empty($departureAgency) ? "selected" : "" ?>>
                    Sélectionnez une agence
                </option>

                <?php foreach ($agencies as $agency): ?>
                    <option
                        value="<?= $agency["id_agence"] ?>"
                        <?= $departureAgency == $agency["id_agence"] ? "selected" : "" ?>
                    >
                        <?= htmlspecialchars($agency["ville"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="row mb-2 align-items-center">
        <label for="id_agence_arrivee" class="col-sm-2 col-form-label">
            Agence d'arrivée :
        </label>
        <div class="col-sm-6">
            <select
                name="id_agence_arrivee"
                id="id_agence_arrivee"
                required
            >
                <option value="" disabled <?= empty($arrivalAgency) ? "selected" : "" ?>>
                    Sélectionnez une agence
                </option>

                <?php foreach ($agencies as $agency): ?>
                    <option
                        value="<?= $agency["id_agence"] ?>"
                        <?= $arrivalAgency == $agency["id_agence"] ? "selected" : "" ?>
                    >
                        <?= htmlspecialchars($agency["ville"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="row mb-2 align-items-center">
        <label for="date_heure_depart" class="col-sm-2 col-form-label">
            Date et heure de départ :
        </label>
        <div class="col-sm-6">
            <input
                type="datetime-local"
                id="date_heure_depart"
                name="date_heure_depart"
                value="<?= htmlspecialchars($departureDate) ?>"
                min="<?= htmlspecialchars(date("Y-m-d\TH:i")) ?>"
                required
            >
        </div>
    </div>

    <div class="row mb-2 align-items-center">
        <label for="date_heure_arrivee" class="col-sm-2 col-form-label">
            Date et heure d'arrivée :
        </label>
        <div class="col-sm-6">
            <input
                type="datetime-local"
                id="date_heure_arrivee"
                name="date_heure_arrivee"
                value="<?= htmlspecialchars($arrivalDate) ?>"
                min="<?= htmlspecialchars($departureDate) ?>"
                required
            >
        </div>
    </div>

    <div class="row mb-4 align-items-center">
        <label for="places_totales" class="col-sm-2 col-form-label">
            Nombre de places :
        </label>
        <div class="col-sm-6">
            <input
                type="number"
                id="places_totales"
                name="places_totales"
                min="1"
                value="<?= htmlspecialchars($places) ?>"
                required
            >
        </div>
    </div>

    <button type="submit" class="btn btn-primary">
        <?= htmlspecialchars($button) ?>
    </button>

    <a
        href="<?= \App\Core\Session::isAdmin() ? "/admin/trips" : "/" ?>"
        class="btn btn-dark"
    >
        Annuler
    </a>
</form>
