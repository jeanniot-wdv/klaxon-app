<!-- app/views/agences/show.php -->
<div class="container my-4">
  <!-- En-tête de l'agence -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <h1 class="card-title mb-3">
            <i class="bi bi-building"></i> <?= htmlspecialchars($agence['nom']) ?>
          </h1>
          <p class="card-text mb-2">
            <i class="bi bi-geo-alt-fill text-primary"></i>
            <strong>Ville:</strong> <?= htmlspecialchars($agence['ville']) ?>
          </p>
          <p class="card-text">
            <i class="bi bi-house-fill text-primary"></i>
            <strong>Adresse:</strong> <?= nl2br(htmlspecialchars($agence['adresse'] ?? 'Non renseignée')) ?>
          </p>
        </div>
        <!-- Boutons d'action pour les admins -->
        <?php if (isset($_SESSION['user_id']) && \App\Models\User::isAdmin($_SESSION['user_id'])): ?>
          <div class="btn-group" role="group">
            <a href="/agences/edit/<?= $agence['id'] ?>" class="btn btn-outline-primary">
              <i class="bi bi-pencil-square"></i> Modifier
            </a>
            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
              <i class="bi bi-trash"></i> Supprimer
            </button>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="card-footer text-muted">
      <small>
        <i class="bi bi-calendar"></i>
        Agence créée le <?= (new DateTime($agence['created_at']))->format('d/m/Y à H:i') ?>
      </small>
    </div>
  </div>

  <!-- Trajets associés -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-car-front-fill"></i> Trajets associés</h2>
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="/trajets/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Proposer un trajet
      </a>
    <?php endif; ?>
  </div>

  <?php if (!empty($trajets)): ?>
    <?php require __DIR__ . '/../components/tableTrajets.php'; ?>
  <?php else: ?>
    <div class="alert alert-info">
      <i class="bi bi-info-circle"></i> Aucun trajet associé à cette agence.
    </div>
  <?php endif; ?>

  <!-- Modale de confirmation de suppression (pour les admins) -->
  <?php if (isset($_SESSION['user_id']) && \App\Models\User::isAdmin($_SESSION['user_id'])): ?>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-danger">
              <i class="bi bi-exclamation-triangle-fill"></i> Confirmer la suppression
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Vous êtes sur le point de supprimer l'agence <strong><?= htmlspecialchars($agence['nom']) ?></strong>.</p>
            <p class="text-danger">Cette action est irréversible et supprimera aussi tous les trajets associés.</p>
            <p>Êtes-vous sûr de vouloir continuer ?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <form action="/agences/delete/<?= $agence['id'] ?>" method="POST">
              <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i> Supprimer définitivement
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Bouton de retour -->
  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a href="/agences" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left"></i> Retour à la liste des agences
    </a>
  </div>
</div>