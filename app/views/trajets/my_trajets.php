<!-- app/views/trajets/my_trajets.php -->
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-list-ul"></i> Mes trajets</h1>
        <a href="/trajets/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Ajouter un trajet
        </a>
    </div>

    <?php if (!empty($trajets)): ?>
        <?php
        include __DIR__ . '/../components/tableTrajets.php';
        ?>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Vous n'avez pas encore créé de trajets.
        </div>
    <?php endif; ?>
</div>
