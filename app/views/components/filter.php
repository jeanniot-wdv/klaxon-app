<!-- Filtre des trajets -->
<section class="mb-5">
  <div class="card bg-info-subtle shadow-sm">
    <div class="card-body">
      <h2 class="card-title mb-4"><i class="bi bi-funnel"></i> Rechercher un trajet</h2>
      <form action="/trajets/recherche" method="GET" class="row g-3">
        <div class="col-md-5">
          <label for="depart" class="form-label">Agence de départ</label>
          <select name="depart" id="depart" class="form-select">
            <option value="">Toutes les agences</option>
            <?php foreach ($agences as $agence): ?>
              <option value="<?= $agence['id'] ?>">
                <?= htmlspecialchars($agence['nom']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-5">
          <label for="arrivee" class="form-label">Agence d'arrivée</label>
          <select name="arrivee" id="arrivee" class="form-select">
            <option value="">Toutes les agences</option>
            <?php foreach ($agences as $agence): ?>
              <option value="<?= $agence['id'] ?>">
                <?= htmlspecialchars($agence['nom']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-search"></i> Filtrer
          </button>
        </div>
      </form>
    </div>
  </div>
</section>