<h1>Liste des utilisateurs</h1>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>Administrateur</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['nom']) ?></td>
                <td><?= htmlspecialchars($user['prenom']) ?></td>
                <td><?= htmlspecialchars($user['telephone']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                    <?= (int) $user['admin'] === 1 ? 'Oui' : 'Non' ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>