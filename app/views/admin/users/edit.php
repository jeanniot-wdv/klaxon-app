<!-- app/views/admin/users/edit.php -->
<div class="container my-4">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h2 class="card-title mb-0"><i class="bi bi-pencil-square"></i> Modifier l'utilisateur</h2>
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

      <form action="/admin/users/update/<?= $user['id'] ?>" method="POST">
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
            <input type="text" name="nom" id="nom" class="form-control"
              value="<?= htmlspecialchars($user['nom']) ?>" required>
          </div>
          <div class="col-md-6">
            <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
            <input type="text" name="prenom" id="prenom" class="form-control"
              value="<?= htmlspecialchars($user['prenom']) ?>" required>
          </div>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
          <input type="email" name="email" id="email" class="form-control"
            value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="password" class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" name="password" id="password" class="form-control" minlength="6">
            <small class="text-muted">Laisser vide pour conserver le mot de passe actuel.</small>
          </div>
          <div class="col-md-6">
            <label for="role" class="form-label">Rôle <span class="text-danger">*</span></label>
            <select name="role" id="role" class="form-select" required>
              <option value="user" <?= ($user['role'] === 'user') ? 'selected' : '' ?>>Utilisateur</option>
              <option value="admin" <?= ($user['role'] === 'admin') ? 'selected' : '' ?>>Administrateur</option>
            </select>
          </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <a href="/admin/users" class="btn btn-outline-secondary me-md-2">
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