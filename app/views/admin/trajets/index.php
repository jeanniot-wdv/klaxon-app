<!-- app/views/admin/trajets/index.php -->
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-car-front"></i> Gestion des trajets</h1>
    <a href="/trajets/create" class="btn btn-primary">
      <i class="bi bi-plus-circle"></i> Ajouter un trajet
    </a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <?php include __DIR__ . '/../../components/tableTrajets.php' ?>
    </div>
  </div>

</div>