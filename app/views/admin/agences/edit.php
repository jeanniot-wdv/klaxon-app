<!-- app/views/admin/agences/edit.php -->
<div class="container my-4">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h2 class="card-title mb-0"><i class="bi bi-pencil-square"></i> Modifier l'agence</h2>
    </div>
    <div class="card-body">
      <!-- Affichage des erreurs -->
      <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach ($_SESSION['errors'] as $error): ?>
              <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
          </ul>
        </div>
      <?php endif; ?>

      <form action="/admin/agences/update/<?= $agence['id'] ?>" method="POST">
        <div class="mb-3">
          <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
          <input type="text" name="nom" id="nom" class="form-control"
            value="<?= htmlspecialchars($agence['nom']) ?>" required>
        </div>

        <div class="mb-3">
          <label for="ville" class="form-label">Ville <span class="text-danger">*</span></label>
          <input type="text" name="ville" id="ville" class="form-control"
            value="<?= htmlspecialchars($agence['ville']) ?>" required>
        </div>

        <div class="mb-3">
          <label for="adresse" class="form-label">Adresse</label>
          <textarea name="adresse" id="adresse" class="form-control" rows="3"><?= htmlspecialchars($agence['adresse']) ?></textarea>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <a href="/admin/agences" class="btn btn-outline-secondary me-md-2">
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