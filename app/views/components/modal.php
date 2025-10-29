<!-- Modale pour les détails du trajet -->
<div class="modal fade" id="trajetModal<?= $trajet['id'] ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bi bi-car-front"></i> Détails du trajet
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <h6><i class="bi bi-buildings"></i> Départ</h6>
          <p><?= htmlspecialchars($trajet['agence_depart']) ?></p>
        </div>
        <div class="mb-3">
          <h6><i class="bi bi-buildings"></i> Arrivée</h6>
          <p><?= htmlspecialchars($trajet['agence_arrivee']) ?></p>
        </div>
        <div class="mb-3">
          <h6><i class="bi bi-calendar"></i> Date et heure</h6>
          <p>
            <span class="badge bg-info">
              <?= (new DateTime($trajet['date_depart']))->format('d/m/Y H:i') ?>
            </span>
          </p>
        </div>
        <div class="mb-3">
          <h6><i class="bi bi-person"></i> Conducteur</h6>
          <p><?= htmlspecialchars($trajet['conducteur']) ?></p>
        </div>
        <div class="mb-3">
          <h6><i class="bi bi-people"></i> Places disponibles</h6>
          <p>
            <span class="badge bg-success">
              <?= $trajet['places_disponibles'] ?> place<?= $trajet['places_disponibles'] > 1 ? 's' : '' ?>
            </span>
          </p>
        </div>
        <?php if (isset($trajet['commentaire']) && !empty($trajet['commentaire'])): ?>
          <div class="mb-3">
            <h6><i class="bi bi-chat-left-text"></i> Commentaire</h6>
            <p><?= nl2br(htmlspecialchars($trajet['commentaire'])) ?></p>
          </div>
        <?php endif; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Fermer
        </button>
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="/trajets/contact/<?= $trajet['id'] ?>" class="btn btn-primary">
            <i class="bi bi-envelope"></i> Contacter
          </a>
        <?php else: ?>
          <a href="/login" class="btn btn-outline-primary">
            <i class="bi bi-box-arrow-in-right"></i> Se connecter
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>