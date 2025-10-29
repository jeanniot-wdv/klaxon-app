<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Klaxon - Covoiturage' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="/">
        <i class="bi bi-car-front-fill"></i> Touche Pas au Klaxon
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="/"><i class="bi bi-house"></i> Accueil</a>
          </li>

          <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="/trajets/create"><i class="bi bi-plus-circle"></i> Ajouter un trajet</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/mes-trajets"><i class="bi bi-list-ul"></i> Mes trajets</a>
            </li>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                  <i class="bi bi-gear"></i> Administration
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="/admin/dashboard">Dashboard</a></li>
                  <li><a class="dropdown-item" href="/admin/users">Utilisateurs</a></li>
                  <li><a class="dropdown-item" href="/admin/trajets">Trajets</a></li>
                  <li><a class="dropdown-item" href="/admin/agences">Agences</a></li>
                </ul>
              </li>
            <?php endif; ?>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['user_prenom']) ?>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right"></i> Déconnexion</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="/login"><i class="bi bi-box-arrow-in-right"></i> Connexion</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/register"><i class="bi bi-person-plus"></i> Inscription</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container mt-4 flex-grow-1">
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>