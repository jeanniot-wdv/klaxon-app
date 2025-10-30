<!-- app/views/trajets/index.php -->
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-car-front-fill"></i> Tous les trajets</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="/trajets/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Proposer un trajet
      </a>
    <?php endif; ?>
  </div>

  <?php include __DIR__ . '/../components/filter.php' ?>

  <!-- Statistiques -->
  <div class="alert alert-info mb-4">
    <i class="bi bi-info-circle"></i>
    <?= $pagination['total'] ?> trajet<?= $pagination['total'] > 1 ? 's' : '' ?> trouvé<?= $pagination['total'] > 1 ? 's' : '' ?>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <?php include __DIR__ . '/../components/tableTrajets.php' ?>
      <?php include __DIR__ . '/../components/pagination.php' ?>
    </div>
  </div>

</div>