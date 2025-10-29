<!-- Statistiques -->
<section class="row text-center mb-5">
  <div class="col-md-4 mb-3">
    <div class="card h-100 shadow-sm">
      <div class="card-body">
        <h3 class="card-title text-primary"><?= $stats['agences'] ?></h3>
        <p class="card-text">Agences référencées</p>
        <i class="bi bi-buildings display-4 text-primary"></i>
      </div>
    </div>
  </div>
  <div class="col-md-4 mb-3">
    <div class="card h-100 shadow-sm">
      <div class="card-body">
        <h3 class="card-title text-success"><?= $stats['trajets'] ?></h3>
        <p class="card-text">Trajets disponibles</p>
        <i class="bi bi-car-front-fill display-4 text-success"></i>
      </div>
    </div>
  </div>
  <div class="col-md-4 mb-3">
    <div class="card h-100 shadow-sm">
      <div class="card-body">
        <h3 class="card-title text-info"><?= $stats['users'] ?></h3>
        <p class="card-text">Utilisateurs inscrits</p>
        <i class="bi bi-people-fill display-4 text-info"></i>
      </div>
    </div>
  </div>
</section>