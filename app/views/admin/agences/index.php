<!-- app/views/admin/agences/index.php -->
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-buildings"></i> Gestion des agences</h1>
    <a href="/admin/agences/create" class="btn btn-primary">
      <i class="bi bi-building-add"></i> Ajouter une agence
    </a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <?php if (!empty($agences)): ?>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Ville</th>
                <th>Adresse</th>
                <th>Créé le</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($agences as $agence): ?>
                <tr>
                  <td><?= $agence['id'] ?></td>
                  <td><?= htmlspecialchars($agence['nom']) ?></td>
                  <td><?= htmlspecialchars($agence['ville']) ?></td>
                  <td><?= nl2br(htmlspecialchars($agence['adresse'])) ?></td>
                  <td><?= (new DateTime($agence['created_at']))->format('d/m/Y H:i') ?></td>
                  <td class="text-center">
                    <a href="/admin/agences/edit/<?= $agence['id'] ?>" class="btn btn-sm btn-outline-secondary">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <form action="/admin/agences/delete/<?= $agence['id'] ?>" method="POST" style="display: inline;">
                      <button type="submit" class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette agence ?')">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="alert alert-info">Aucune agence trouvée.</div>
      <?php endif; ?>
    </div>
  </div>
</div>