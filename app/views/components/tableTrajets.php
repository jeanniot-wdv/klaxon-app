<div class="table-responsive mb-4">
  <table class="table table-striped table-hover align-middle">
    <thead class="table-light">
      <tr>
        <th><i class="bi bi-signpost-2"></i> Départ → Arrivée</th>
        <th><i class="bi bi-calendar-event"></i> Date/Heure</th>
        <th><i class="bi bi-person-fill"></i> Conducteur</th>
        <th><i class="bi bi-people-fill"></i> Places</th>
        <th class="text-center"><i class="bi bi-info-circle"></i> Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($trajets as $trajet): ?>
        <tr>
          <td>
            <strong><?= htmlspecialchars($trajet['agence_depart'] ?? 'Inconnu') ?></strong>
            <i class="bi bi-arrow-right"></i>
            <strong><?= htmlspecialchars($trajet['agence_arrivee'] ?? 'Inconnu') ?></strong>
          </td>
          <td>
            <span class="badge bg-info">
              <?= (new DateTime($trajet['date_depart']))->format('d/m/Y') ?>
            </span>
            à <?= (new DateTime($trajet['date_depart']))->format('H:i') ?>
          </td>
          <td>
            <?= htmlspecialchars($trajet['conducteur'] ?? 'Conducteur inconnu') ?>
          </td>
          <td>
            <span class="badge bg-<?= ($trajet['places_disponibles'] ?? 0) > 0 ? 'success' : 'secondary' ?>">
              <?= $trajet['places_disponibles'] ?? 0 ?> place<?= ($trajet['places_disponibles'] ?? 0) > 1 ? 's' : '' ?>
            </span>
          </td>
          <td class="text-center">
            <?php if (\App\Models\Auth::isAdmin() === false): ?>
              <button class="btn btn-sm btn-outline-primary"
                data-bs-toggle="modal"
                data-bs-target="#trajetModal<?= $trajet['id'] ?>">
                <i class="bi bi-eye"></i> Voir
              </button>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['user_id']) && (($trajet['user_id'] ?? null) == $_SESSION['user_id'] || \App\Models\Auth::isAdmin())): ?>
              <a href="/trajets/edit/<?= $trajet['id'] ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-pencil"></i>
              </a>

              <form action="/trajets/delete/<?= $trajet['id'] ?>" method="POST" style="display: inline;">
                <button type="submit" class="btn btn-sm btn-outline-danger"
                  onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?')">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            <?php endif; ?>
          </td>
        </tr>
        <?php require __DIR__ . '/../components/modal.php'; ?>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>