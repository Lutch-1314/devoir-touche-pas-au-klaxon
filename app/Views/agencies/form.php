<?php
/** @var string $title */
/** @var string $action */
/** @var string $button */
/** @var array $agency */
?>

<h1><?= htmlspecialchars($title) ?></h1>

<form action="<?= htmlspecialchars($action) ?>" method="POST">

    <div class="row mb-4">
        <input
            type="hidden"
            name="id_agence"

            value="<?= htmlspecialchars($agency["id_agence"]) ?>"
        >

        <label for="ville" class="col-sm-1  col-form-label">
            Ville
        </label>
        
        <div class="col-sm-4">
            <input
                type="text"
                class="form-control"
                id="ville"
                name="ville"
                value="<?= htmlspecialchars($agency["ville"]) ?>"
                required
            >
        </div>
    </div>

    <div>
        <button type="submit"
            class="btn btn-primary">
            <?= htmlspecialchars($button) ?>
        </button>

        <a href="/admin/agencies"
            class="btn btn-dark">
            Annuler
        </a>
    </div>
</form>
