<!-- app/views/trajets/contact.php -->
<div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="card-title mb-0">
                <i class="bi bi-envelope"></i> Contacter le conducteur
            </h2>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <h3><i class="bi bi-car-front"></i> Trajet : <?= htmlspecialchars($trajet['agence_depart']) ?> → <?= htmlspecialchars($trajet['agence_arrivee']) ?></h3>
                <p class="text-muted">
                    <i class="bi bi-calendar"></i> <?= (new DateTime($trajet['date_depart']))->format('d/m/Y H:i') ?>
                </p>
                <p class="text-muted">
                    <i class="bi bi-person"></i> Conducteur : <?= htmlspecialchars($trajet['conducteur']) ?>
                </p>
            </div>

            <form action="/trajets/send-message/<?= $trajet['id'] ?>" method="POST">
                <div class="mb-3">
                    <label for="message" class="form-label">Votre message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Envoyer le message
                    </button>
                    <a href="/" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Retour à l'accueil
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
