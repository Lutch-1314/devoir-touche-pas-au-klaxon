<h1>Connexion</h1>

<?php if (isset($error)): ?>

    <p>
        <?= htmlspecialchars($error) ?>
    </p>

<?php endif; ?>

<form action="/login" method="POST">

    <div>
        <label for="email">Adresse e-mail</label>

        <input
            type="email"
            id="email"
            name="email"
            required
        >
    </div>

    <div>
        <label for="mot_de_passe">Mot de passe</label>

        <input
            type="password"
            id="mot_de_passe"
            name="mot_de_passe"
            required
        >
    </div>

    <button type="submit">
        Se connecter
    </button>

</form>