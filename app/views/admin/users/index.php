<!-- app/views/admin/users/index.php -->
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-people"></i> Gestion des utilisateurs</h1>
    <a href="/admin/users/create" class="btn btn-primary">
      <i class="bi bi-person-plus"></i> Ajouter un utilisateur
    </a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <?php if (!empty($users)): ?>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Créé le</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?= $user['id'] ?></td>
                  <td><?= htmlspecialchars($user['nom']) ?></td>
                  <td><?= htmlspecialchars($user['prenom']) ?></td>
                  <td><?= htmlspecialchars($user['email']) ?></td>
                  <td>
                    <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'primary' ?>">
                      <?= htmlspecialchars(ucfirst($user['role'])) ?>
                    </span>
                  </td>
                  <td><?= (new DateTime($user['created_at']))->format('d/m/Y H:i') ?></td>
                  <td class="text-center">
                    <a href="/admin/users/edit/<?= $user['id'] ?>" class="btn btn-sm btn-outline-secondary">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <?php if ($user['id'] !== $_SESSION['user_id']): ?>
                      <form action="/admin/users/delete/<?= $user['id'] ?>" method="POST" style="display: inline;">
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                          onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                          <i class="bi bi-trash"></i>
                        </button>
                      </form>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="alert alert-info">Aucun utilisateur trouvé.</div>
      <?php endif; ?>
    </div>
  </div>
</div>