<h1><?= htmlspecialchars($title) ?></h1>

<?php if (isset($error)): ?>

    <p>
        <?= htmlspecialchars($error) ?>
    </p>

<?php endif; ?>

<form action="<?= htmlspecialchars($action) ?>" method="POST">


    <input
        type="hidden"
        name="id_agence"
        value="<?= htmlspecialchars($agency['id_agence']) ?>">

    <div>
        <label for="ville">
            Ville
        </label>

        <input
            type="text"
            id="ville"
            name="ville"
            value="<?= htmlspecialchars($agency['ville']) ?>"
            required>
    </div>

    <div>

        <button type="submit">
            <?= htmlspecialchars($button) ?>
        </button>

        <a href="/admin/agencies">
            Annuler
        </a>
    </div>
</form>