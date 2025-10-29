<!-- app/views/trajets/edit.php -->
<div class="container my-4">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h2 class="card-title mb-0"><i class="bi bi-pencil-square"></i> Modifier le trajet</h2>
    </div>
    <div class="card-body">
      <form action="/trajets/update/<?= $trajet['id'] ?>" method="POST">
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="agence_depart_id" class="form-label">Agence de départ</label>
            <select name="agence_depart_id" id="agence_depart_id" class="form-select" required>
              <option value="">Sélectionnez une agence</option>
              <?php foreach ($agences as $agence): ?>
                <option value="<?= $agence['id'] ?>" <?= $agence['id'] == $trajet['agence_depart_id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($agence['nom']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label for="agence_arrivee_id" class="form-label">Agence d'arrivée</label>
            <select name="agence_arrivee_id" id="agence_arrivee_id" class="form-select" required>
              <option value="">Sélectionnez une agence</option>
              <?php foreach ($agences as $agence): ?>
                <option value="<?= $agence['id'] ?>" <?= $agence['id'] == $trajet['agence_arrivee_id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($agence['nom']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="date_depart" class="form-label">Date et heure de départ</label>
            <input type="datetime-local" name="date_depart" id="date_depart" class="form-control"
              value="<?= date('Y-m-d\TH:i', strtotime($trajet['date_depart'])) ?>" required>
          </div>
          <div class="col-md-6">
            <label for="date_arrivee" class="form-label">Date et heure d'arrivée</label>
            <input type="datetime-local" name="date_arrivee" id="date_arrivee" class="form-control"
              value="<?= date('Y-m-d\TH:i', strtotime($trajet['date_arrivee'])) ?>" required>
          </div>
        </div>

        <div class="mb-3">
          <label for="places_disponibles" class="form-label">Places disponibles</label>
          <input type="number" name="places_disponibles" id="places_disponibles" class="form-control"
            value="<?= $trajet['places_disponibles'] ?>" min="1" required>
        </div>

        <div class="mb-3">
          <label for="commentaire" class="form-label">Commentaire (optionnel)</label>
          <textarea name="commentaire" id="commentaire" class="form-control" rows="3"><?= htmlspecialchars($trajet['commentaire'] ?? '') ?></textarea>
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