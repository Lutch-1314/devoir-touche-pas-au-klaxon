<div
    class="modal fade"
    id="tripModal<?= $trip['id_trajet'] ?>"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Informations du conducteur
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <p>
                    <strong>Conducteur :</strong><br>
                    <?= htmlspecialchars($trip['prenom']) ?>
                    <?= htmlspecialchars($trip['nom']) ?>
                </p>

                <p>
                    <strong>Téléphone :</strong><br>
                    <?= htmlspecialchars($trip['telephone']) ?>
                </p>

                <p>
                    <strong>Email :</strong><br>
                    <?= htmlspecialchars($trip['email']) ?>
                </p>

                <p>
                    <strong>Nombre total de places :</strong><br>
                    <?= htmlspecialchars($trip['places_totales']) ?>
                </p>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Fermer
                </button>

            </div>

        </div>

    </div>

</div>