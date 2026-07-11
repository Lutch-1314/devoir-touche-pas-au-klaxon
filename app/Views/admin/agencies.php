<h1>Liste des agences</h1>

<?php if ($flash): ?>

    <p class="<?= htmlspecialchars($flash['type']) ?>">
        <?= htmlspecialchars($flash['message']) ?>
    </p>

<?php endif; ?>

<p>
    <a href="/agencies/create">
        Ajouter une nouvelle agence
    </a>
</p>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>ID</th>
            <th>Ville</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($agencies as $agency): ?>

            <tr>
                <td><?= htmlspecialchars($agency['id_agence']) ?></td>

                <td><?= htmlspecialchars($agency['ville']) ?></td>

                <td>

                    <a href="/agencies/edit?id=<?= $agency['id_agence'] ?>">
                        Modifier
                    </a>

                    <form
                        action="/agencies/delete"
                        method="POST"
                    >

                        <input
                            type="hidden"
                            name="id_agence"
                            value="<?= $agency['id_agence'] ?>"
                        >

                        <button
                            type="submit"
                            onclick="return confirm('Supprimer cette agence ?')"
                        >
                            Supprimer
                        </button>

                    </form>

                </td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>