<!-- app/views/agences/show.php -->
<div class="container my-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h1 class="card-title">
                <i class="bi bi-building"></i> <?= htmlspecialchars($agence['nom']) ?>
            </h1>
            <p class="card-text">
                <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($agence['ville']) ?><br>
                <i class="bi bi-house"></i> <?= nl2br(htmlspecialchars($agence['adresse'])) ?>
            </p>
        </div>
    </div>

    <h2 class="mb-4"><i class="bi bi-car-front"></i> Trajets associés</h2>
    <?php if (!empty($trajets)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Départ</th>
                        <th>Arrivée</th>
                        <th>Date</th>
                        <th>Conducteur</th>
                        <th>Places</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trajets as $trajet): ?>
                        <tr>
                            <td><?= htmlspecialchars($trajet['agence_depart']) ?></td>
                            <td><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
                            <td><?= (new DateTime($trajet['date_depart']))->format('d/m/Y H:i') ?></td>
                            <td><?= htmlspecialchars($trajet['conducteur']) ?></td>
                            <td>
                                <span class="badge bg-success">
                                    <?= $trajet['places_disponibles'] ?> place<?= $trajet['places_disponibles'] > 1 ? 's' : '' ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Aucun trajet associé à cette agence.</div>
    <?php endif; ?>

    <a href="/" class="btn btn-outline-primary mt-3">
        <i class="bi bi-arrow-left"></i> Retour à l'accueil
    </a>
</div>
