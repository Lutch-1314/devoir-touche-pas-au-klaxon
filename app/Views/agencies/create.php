<h1>Créer une agence</h1>

<?php if (isset($error)): ?>

    <p>
        <?= htmlspecialchars($error) ?>
    </p>

<?php endif; ?>

<form action="/agencies/create" method="POST">

    <div>
        <label for="ville">
            Ville
        </label>

        <input
            type="text"
            id="ville"
            name="ville"
            required
        >
    </div>

    <button type="submit">
        Créer
    </button>

</form>