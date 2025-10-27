<!-- app/views/agences/index.php -->
<div class="container my-4">
  <h1 class="mb-4"><i class="bi bi-buildings"></i> Liste des agences</h1>

  <?php if (!empty($agences)): ?>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php foreach ($agences as $agence): ?>
        <div class="col">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($agence['nom']) ?></h5>
              <p class="card-text">
                <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($agence['ville']) ?>
              </p>
            </div>
            <div class="card-footer">
              <a href="/agences/<?= $agence['id'] ?>" class="btn btn-primary w-100">
                <i class="bi bi-eye"></i> Voir les détails
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-warning">Aucune agence trouvée.</div>
  <?php endif; ?>
</div>