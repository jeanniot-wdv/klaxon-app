<!-- app/views/home/index.php -->
<div class="container">
  <h1 class="text-center mt-2">Bienvenue sur notre plateforme de covoiturage</h1>
  <p class="text-center fs-5 mb-5">Trouvez facilement des trajets ou proposez le vôtre pour voyager malin et convivial !</p>

  <?php require __DIR__ . '/../components/stats.php'; ?>
  <?php require __DIR__ . '/../components/filter.php'; ?>

  <!-- Dernières agences -->
  <section class="mb-5">
    <h2 class="mb-4"><i class="bi bi-buildings"></i> Dernières agences ajoutées</h2>
    <?php if (!empty($agences)): ?>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($agences as $agence): ?>
          <div class="col">
            <div class="card h-100 shadow-sm">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($agence['nom']) ?></h5>
                <p class="card-text">
                  <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($agence['ville']) ?>
                </p>
              </div>
              <div class="card-footer bg-transparent">
                <a href="/agences/<?= $agence['id'] ?>" class="btn btn-outline-primary w-100">
                  <i class="bi bi-eye"></i> Voir les trajets
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="alert alert-warning">Aucune agence trouvée.</div>
    <?php endif; ?>
  </section>

  <!-- Trajets récents -->
  <section class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2><i class="bi bi-calendar-event"></i> Prochains trajets</h2>
      <a href="/trajets" class="btn btn-outline-secondary">
        <i class="bi bi-list"></i> Voir tous les trajets
      </a>
    </div>
    
    <?php if (!empty($trajets)): ?>
      <?php require __DIR__ . '/../components/tableTrajets.php'; ?>
    <?php else: ?>
      <div class="alert alert-info">Aucun trajet disponible.</div>
    <?php endif; ?>
  </section>

  <!-- Call-to-action -->
  <section class="text-center">
    <a href="/trajets/recherche" class="btn btn-primary btn-lg me-2">
      <i class="bi bi-search"></i> Rechercher un trajet
    </a>
    <a href="/agences" class="btn btn-outline-primary btn-lg">
      <i class="bi bi-buildings"></i> Voir toutes les agences
    </a>
  </section>
</div>