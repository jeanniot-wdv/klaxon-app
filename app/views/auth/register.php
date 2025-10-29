<!-- app/views/auth/register.php -->
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">
          <h2 class="card-title mb-0 text-center"><i class="bi bi-person-plus"></i> Inscription</h2>
        </div>
        <div class="card-body">
          <!-- Affiche les messages d'erreur SI ils existent -->
          <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
              <?= htmlspecialchars($_SESSION['error']) ?>
              <?php unset($_SESSION['error']); ?>
            </div>
          <?php endif; ?>

          <form action="/register" method="POST">
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="form-control" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" required minlength="6">
              </div>
              <div class="col-md-6">
                <label for="password_confirm" class="form-label">Confirmer le mot de passe</label>
                <input type="password" name="password_confirm" id="password_confirm" class="form-control" required minlength="6">
              </div>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> S'inscrire
              </button>
            </div>
          </form>

          <div class="mt-3 text-center">
            <p>Déjà un compte ? <a href="/login">Se connecter</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>