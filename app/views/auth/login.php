<!-- app/views/auth/login.php -->
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">
          <h2 class="card-title mb-0 text-center"><i class="bi bi-box-arrow-in-right"></i> Connexion</h2>
        </div>
        <div class="card-body">
          <!-- Affiche les erreurs UNIQUEMENT si elles existent dans $_SESSION -->
          <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
              <?= htmlspecialchars($_SESSION['error']) ?>
              <?php unset($_SESSION['error']); // Supprime l'erreur après affichage 
              ?>
            </div>
          <?php endif; ?>

          <form action="/login" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" id="email" class="form-control" required
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Mot de passe</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-box-arrow-in-right"></i> Se connecter
              </button>
            </div>
          </form>
          <div class="mt-3 text-center">
            <p>Pas encore de compte ? <a href="/register">S'inscrire</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>