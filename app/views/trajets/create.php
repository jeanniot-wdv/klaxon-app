<!-- app/views/trajets/create.php -->
<div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="card-title mb-0"><i class="bi bi-plus-circle"></i> Créer un nouveau trajet</h2>
        </div>
        <div class="card-body">
            <!-- Affichage des messages d'erreur -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Affichage des erreurs de validation spécifiques -->
            <?php if (isset($errors) && is_array($errors) && count($errors) > 0): ?>
                <div class="alert alert-warning">
                    <strong><i class="bi bi-exclamation-triangle"></i> Veuillez corriger les erreurs suivantes :</strong>
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/trajets/store" method="POST">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="agence_depart_id" class="form-label">Agence de départ <span class="text-danger">*</span></label>
                        <select name="agence_depart_id" id="agence_depart_id" class="form-select <?= isset($errors['agence_depart_id']) ? 'is-invalid' : '' ?>" required>
                            <option value="">Sélectionnez une agence de départ</option>
                            <?php foreach ($agences as $agence): ?>
                                <option value="<?= $agence['id'] ?>" <?= (isset($_POST['agence_depart_id']) && $_POST['agence_depart_id'] == $agence['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($agence['nom']) ?> (<?= htmlspecialchars($agence['ville']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['agence_depart_id'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['agence_depart_id']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6">
                        <label for="agence_arrivee_id" class="form-label">Agence d'arrivée <span class="text-danger">*</span></label>
                        <select name="agence_arrivee_id" id="agence_arrivee_id" class="form-select <?= isset($errors['agence_arrivee_id']) ? 'is-invalid' : '' ?>" required>
                            <option value="">Sélectionnez une agence d'arrivée</option>
                            <?php foreach ($agences as $agence): ?>
                                <option value="<?= $agence['id'] ?>" <?= (isset($_POST['agence_arrivee_id']) && $_POST['agence_arrivee_id'] == $agence['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($agence['nom']) ?> (<?= htmlspecialchars($agence['ville']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['agence_arrivee_id'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['agence_arrivee_id']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="date_depart" class="form-label">Date et heure de départ <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="date_depart" id="date_depart"
                               class="form-control <?= isset($errors['date_depart']) ? 'is-invalid' : '' ?>"
                               value="<?= htmlspecialchars($_POST['date_depart'] ?? '') ?>" required>
                        <?php if (isset($errors['date_depart'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['date_depart']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6">
                        <label for="date_arrivee" class="form-label">Date et heure d'arrivée <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="date_arrivee" id="date_arrivee"
                               class="form-control <?= isset($errors['date_arrivee']) ? 'is-invalid' : '' ?>"
                               value="<?= htmlspecialchars($_POST['date_arrivee'] ?? '') ?>" required>
                        <?php if (isset($errors['date_arrivee'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['date_arrivee']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="places_disponibles" class="form-label">Nombre de places disponibles <span class="text-danger">*</span></label>
                    <input type="number" name="places_disponibles" id="places_disponibles"
                           class="form-control <?= isset($errors['places_disponibles']) ? 'is-invalid' : '' ?>"
                           value="<?= htmlspecialchars($_POST['places_disponibles'] ?? '1') ?>"
                           min="1" max="10" required>
                    <?php if (isset($errors['places_disponibles'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($errors['places_disponibles']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="commentaire" class="form-label">Commentaire (optionnel)</label>
                    <textarea name="commentaire" id="commentaire" class="form-control" rows="3"><?= htmlspecialchars($_POST['commentaire'] ?? '') ?></textarea>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="/trajets" class="btn btn-outline-secondary me-md-2">
                        <i class="bi bi-arrow-left"></i> Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script pour valider que la date d'arrivée est après la date de départ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateDepartInput = document.getElementById('date_depart');
    const dateArriveeInput = document.getElementById('date_arrivee');

    function validateDates() {
        const dateDepart = new Date(dateDepartInput.value);
        const dateArrivee = new Date(dateArriveeInput.value);

        if (dateDepart && dateArrivee && dateArrivee <= dateDepart) {
            dateArriveeInput.setCustomValidity("La date d'arrivée doit être postérieure à la date de départ");
        } else {
            dateArriveeInput.setCustomValidity("");
        }
    }

    dateDepartInput.addEventListener('change', validateDates);
    dateArriveeInput.addEventListener('change', validateDates);
});
</script>
