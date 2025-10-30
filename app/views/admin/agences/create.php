<!-- app/views/admin/agences/create.php -->
<div class="container my-4">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h2 class="card-title mb-0"><i class="bi bi-building-add"></i> Créer une agence</h2>
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

      <form action="/admin/agences/store" method="POST">
        <div class="mb-3">
          <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
          <input type="text" name="nom" id="nom" class="form-control"
            value="<?= htmlspecialchars($_SESSION['old_input']['nom'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
          <label for="ville" class="form-label">Ville <span class="text-danger">*</span></label>
          <input type="text" name="ville" id="ville" class="form-control"
            value="<?= htmlspecialchars($_SESSION['old_input']['ville'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
          <label for="adresse" class="form-label">Adresse</label>
          <textarea name="adresse" id="adresse" class="form-control" rows="3"><?= htmlspecialchars($_SESSION['old_input']['adresse'] ?? '') ?></textarea>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <a href="/admin/agences" class="btn btn-outline-secondary me-md-2">
            <i class="bi bi-arrow-left"></i> Annuler
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Enregistrer
          </button>
        </div>
        <?php unset($_SESSION['old_input']); ?>
      </form>
    </div>
  </div>
</div>