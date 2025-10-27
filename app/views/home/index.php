<!-- app/views/home/index.php -->
<div class="container my-4">
    <h1 class="text-center mb-4"><?= htmlspecialchars($title) ?></h1>

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

    <!-- Filtre des trajets -->
    <section class="mb-5">
        <div class="card shadow-sm">
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

    <!-- Dernières agences -->
    <section class="mb-5">
        <h2 class="mb-4"><i class="bi bi-buildings"></i> Dernières agences ajoutées</h2>
        <?php if (!empty($agences)): ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($agences as $agence): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($agence['nom']) ?></h5>
                                <p class="card-text">
                                    <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($agence['ville']) ?>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="/agences/<?= $agence['id'] ?>" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-eye"></i> Voir les trajets
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">Aucune agence trouvée.</div>
        <?php endif; ?>
    </section>

    <!-- Trajets récents -->
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-calendar-event"></i> Prochains trajets</h2>
            <a href="/trajets" class="btn btn-outline-secondary">
                <i class="bi bi-list"></i> Voir tous les trajets
            </a>
        </div>
        <?php if (!empty($trajets)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-buildings"></i> Départ</th>
                            <th><i class="bi bi-buildings"></i> Arrivée</th>
                            <th><i class="bi bi-calendar"></i> Date/Heure</th>
                            <th><i class="bi bi-people"></i> Places</th>
                            <th><i class="bi bi-person"></i> Conducteur</th>
                            <th class="text-center"><i class="bi bi-info-circle"></i> Détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($trajets as $trajet): ?>
                            <tr>
                                <td><?= htmlspecialchars($trajet['agence_depart']) ?></td>
                                <td><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
                                <td>
                                    <span class="badge bg-info">
                                        <?= (new DateTime($trajet['date_depart']))->format('d/m/Y H:i') ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        <?= $trajet['places_disponibles'] ?> place<?= $trajet['places_disponibles'] > 1 ? 's' : '' ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($trajet['conducteur']) ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#trajetModal<?= $trajet['id'] ?>">
                                        <i class="bi bi-eye"></i> Voir
                                    </button>
                                </td>
                            </tr>

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
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Aucun trajet disponible.</div>
        <?php endif; ?>
    </section>

    <!-- Call-to-action -->
    <section class="text-center py-4">
        <a href="/trajets/recherche" class="btn btn-primary btn-lg me-2">
            <i class="bi bi-search"></i> Rechercher un trajet
        </a>
        <a href="/agences" class="btn btn-outline-primary btn-lg">
            <i class="bi bi-buildings"></i> Voir toutes les agences
        </a>
    </section>
</div>