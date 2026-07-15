<h1>Connexion</h1>

<?php if (isset($error)): ?>

    <p>
        <?= htmlspecialchars($error) ?>
    </p>

<?php endif; ?>

<div class="col-lg-3">
    <form action="/login" method="POST">

        <div class="mb-3">
            <label class="form-label" for="email">Adresse e-mail</label>

            <input
                class="form-control"
                type="email"
                id="email"
                name="email"
                autocomplete="username"
                required>
        </div>

        <div class="mb-4">
            <label class="form-label" for="mot_de_passe">Mot de passe</label>

            <input
                class="form-control"
                type="password"
                id="mot_de_passe"
                name="mot_de_passe"
                autocomplete="current-password"
                required>
        </div>

        <button class="btn btn-primary" type="submit">
            Se connecter
        </button>

    </form>
</div>