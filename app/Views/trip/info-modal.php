<div
    class="modal fade"
    id="tripModal<?= $trip["id_trajet"] ?>"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body text-start">
                <p>
                    Auteur :
                    <strong>   
                        <?= htmlspecialchars($trip["prenom"]) ?>
                        <?= htmlspecialchars($trip["nom"]) ?>
                    </strong>
                </p>
                <p>
                    Téléphone :
                    <strong>
                        <?= chunk_split(htmlspecialchars($trip["telephone"]), 2, " ") ?>
                    </strong>
                </p>
                <p>
                    Email :
                    <strong>
                        <?= htmlspecialchars($trip["email"]) ?></strong>
                </p>
                <p>
                    Nombre total de places :
                    <?= htmlspecialchars($trip["places_totales"]) ?>
                </p>
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-dark"
                    data-bs-dismiss="modal">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>
