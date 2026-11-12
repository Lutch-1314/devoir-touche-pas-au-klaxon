<?php
/** @var array $agencies */
?>

<h1>Liste des agences</h1>

<p>
    <a href="/agencies/create">
        Ajouter une nouvelle agence
    </a>
</p>

<table class="table table-bordered w-auto
">
    <thead>
        <tr>
            <th>Ville</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($agencies as $agency): ?>

            <tr>
                <td><?= htmlspecialchars($agency["ville"]) ?></td>
                <td  class="d-flex">
                    <button
                        type="button"
                        class="btn"
                        onclick="window.location.href='/agencies/edit?id=<?= $agency[
                            "id_agence"
                        ] ?>'"
                    >
                        <i class="bi bi-pencil-square"></i>
                    </button>

                    <form
                        action="/agencies/delete"
                        method="POST">

                        <input
                            type="hidden"
                            name="id_agence"
                            value="<?= $agency["id_agence"] ?>">

                        <button
                            type="submit"
                            class="btn"
                            onclick="return confirm('Supprimer cette agence ?')">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </td>
            </tr>

        <?php endforeach; ?>
        
    </tbody>
</table>
