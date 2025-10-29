<!-- app/views/components/filter.php -->
<div class="card bg-info-subtle shadow-sm mb-4">
  <div class="card-body">
    <h2 class="card-title mb-4"><i class="bi bi-funnel"></i> Filtrer les trajets</h2>
    <form action="/trajets" method="GET" class="row g-3">

      <div class="col-md-5">
        <label for="depart" class="form-label">Agence de départ</label>
        <select name="depart" id="depart" class="form-select">
          <option value="">Toutes les agences</option>
          <?php foreach ($agences as $agence): ?>
            <option value="<?= $agence['id'] ?>" <?= (($currentFilters['depart'] ?? null) == $agence['id']) ? 'selected' : '' ?>>
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
            <option value="<?= $agence['id'] ?>" <?= (($currentFilters['arrivee'] ?? null) == $agence['id']) ? 'selected' : '' ?>>
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