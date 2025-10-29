<?php

namespace App\Controllers;

use Core\Controller;
use Core\Database;
use Core\Middleware\AuthMiddleware;
use App\Models\Trajet;
use App\Models\Agence;

class TrajetController extends Controller
{
  // Méthode pour afficher la liste des trajets avec pagination et filtres
  public function index(): void
  {
    // Récupère les filtres depuis l'URL
    $departId = $_GET['depart'] ?? null;
    $arriveeId = $_GET['arrivee'] ?? null;
    $page = (int)($_GET['page'] ?? 1);
    $page = max(1, $page); // Assure que la page est au moins 1

    // Récupère les trajets avec pagination via le modèle
    $data = Trajet::getAllWithPagination($page, 10, $departId, $arriveeId);

    // Récupère toutes les agences pour le filtre
    $agences = Agence::all();

    // Prépare les données pour la vue
    $this->render('trajets/index', [
      'title' => 'Tous les trajets',
      'trajets' => $data['trajets'],
      'pagination' => [
        'currentPage' => $data['currentPage'],
        'pages' => $data['pages'],
        'total' => $data['total']
      ],
      'agences' => $agences,
      'currentFilters' => [
        'depart' => $departId,
        'arrivee' => $arriveeId
      ]
    ]);
  }

  // Affiche le formulaire de création (connecté requis)
  public function create(): void
  {
    // Vérifie que l'utilisateur est connecté
    if (!\App\Models\Auth::isLoggedIn()) {
      $_SESSION['error'] = "Vous devez être connecté pour créer un trajet.";
      header('Location: /login');
      exit;
    }

    $agences = \App\Models\Agence::all();
    $this->render('trajets/create', [
      'title' => 'Créer un trajet',
      'agences' => $agences,
      'errors' => $_SESSION['errors'] ?? []
    ]);
    unset($_SESSION['errors']);
  }

  // Traite la création d'un nouveau trajet (connecté requis)
  public function store(): void
  {
    if (!\App\Models\Auth::isLoggedIn()) {
      $_SESSION['error'] = "Vous devez être connecté pour créer un trajet.";
      header('Location: /login');
      exit;
    }

    // Récupère les données du formulaire
    $agenceDepartId = (int)($_POST['agence_depart_id'] ?? 0);
    $agenceArriveeId = (int)($_POST['agence_arrivee_id'] ?? 0);
    $dateDepart = $_POST['date_depart'] ?? '';
    $dateArrivee = $_POST['date_arrivee'] ?? '';
    $placesDisponibles = (int)($_POST['places_disponibles'] ?? 0);
    $commentaire = trim($_POST['commentaire'] ?? null);

    // Validation des données
    $errors = [];

    if ($agenceDepartId <= 0) {
      $errors['agence_depart_id'] = "L'agence de départ est obligatoire.";
    }

    if ($agenceArriveeId <= 0) {
      $errors['agence_arrivee_id'] = "L'agence d'arrivée est obligatoire.";
    }

    if (empty($dateDepart)) {
      $errors['date_depart'] = "La date de départ est obligatoire.";
    } elseif (!strtotime($dateDepart)) {
      $errors['date_depart'] = "La date de départ n'est pas valide.";
    }

    if (empty($dateArrivee)) {
      $errors['date_arrivee'] = "La date d'arrivée est obligatoire.";
    } elseif (!strtotime($dateArrivee)) {
      $errors['date_arrivee'] = "La date d'arrivée n'est pas valide.";
    } elseif (strtotime($dateArrivee) <= strtotime($dateDepart)) {
      $errors['date_arrivee'] = "La date d'arrivée doit être postérieure à la date de départ.";
    }

    if ($placesDisponibles <= 0 || $placesDisponibles > 10) {
      $errors['places_disponibles'] = "Le nombre de places doit être compris entre 1 et 10.";
    }

    if ($agenceDepartId === $agenceArriveeId) {
      $errors['agence_arrivee_id'] = "L'agence d'arrivée doit être différente de l'agence de départ.";
    }

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
      $_SESSION['old_input'] = $_POST;
      header('Location: /trajets/create');
      exit;
    }

    // Crée le trajet
    if (\App\Models\Trajet::create(
      $_SESSION['user_id'],
      $agenceDepartId,
      $agenceArriveeId,
      $dateDepart,
      $dateArrivee,
      $placesDisponibles,
      $commentaire
    )) {
      $_SESSION['success'] = "Trajet créé avec succès !";
      header('Location: /mes-trajets');
    } else {
      $_SESSION['error'] = "Erreur lors de la création du trajet.";
      header('Location: /trajets/create');
    }
    exit;
  }

  // Affiche le formulaire de modification (propriétaire ou admin requis)
  public function edit(int $id): void
  {
    AuthMiddleware::requireLogin();
    AuthMiddleware::requireTrajetOwner($id);

    $trajet = Trajet::find($id);
    if (!$trajet) {
      $_SESSION['error'] = "Trajet non trouvé.";
      header('Location: /trajets');
      exit;
    }

    $agences = Agence::all();
    $this->render('trajets/edit', [
      'title' => "Modifier le trajet",
      'trajet' => $trajet,
      'agences' => $agences
    ]);
  }

  // Traite la mise à jour d'un trajet (propriétaire ou admin requis)
  public function update(int $id): void
  {
    // Vérifie que l'utilisateur est connecté
    if (!\App\Models\Auth::isLoggedIn()) {
      $_SESSION['error'] = "Vous devez être connecté.";
      header('Location: /login');
      exit;
    }

    // Récupère le trajet
    $trajet = \App\Models\Trajet::find($id);
    if (!$trajet) {
      $_SESSION['error'] = "Trajet non trouvé.";
      header('Location: /trajets');
      exit;
    }

    // Vérifie que l'utilisateur est propriétaire ou admin
    if ($trajet['user_id'] !== $_SESSION['user_id'] && !\App\Models\Auth::isAdmin()) {
      $_SESSION['error'] = "Vous n'êtes pas autorisé à modifier ce trajet.";
      header('Location: /trajets');
      exit;
    }

    // Récupère les données du formulaire
    $agenceDepartId = (int)($_POST['agence_depart_id'] ?? 0);
    $agenceArriveeId = (int)($_POST['agence_arrivee_id'] ?? 0);
    $dateDepart = $_POST['date_depart'] ?? '';
    $dateArrivee = $_POST['date_arrivee'] ?? '';
    $placesDisponibles = (int)($_POST['places_disponibles'] ?? 0);
    $commentaire = trim($_POST['commentaire'] ?? null);

    // Validation des données
    $errors = [];
    if ($agenceDepartId <= 0) $errors[] = "L'agence de départ est obligatoire.";
    if ($agenceArriveeId <= 0) $errors[] = "L'agence d'arrivée est obligatoire.";
    if (empty($dateDepart)) $errors[] = "La date de départ est obligatoire.";
    if (empty($dateArrivee)) $errors[] = "La date d'arrivée est obligatoire.";
    if ($placesDisponibles <= 0) $errors[] = "Le nombre de places doit être supérieur à 0.";
    if (strtotime($dateDepart) >= strtotime($dateArrivee)) $errors[] = "La date de départ doit être antérieure à la date d'arrivée.";

    if (!empty($errors)) {
      $_SESSION['error'] = implode("<br>", $errors);
      header("Location: /trajets/edit/$id");
      exit;
    }

    // Met à jour le trajet
    if (\App\Models\Trajet::update(
      $id,
      $agenceDepartId,
      $agenceArriveeId,
      $dateDepart,
      $dateArrivee,
      $placesDisponibles,
      $commentaire
    )) {
      header("Location: /trajets");
      $_SESSION['success'] = "Trajet mis à jour avec succès !";
    } else {
      $_SESSION['error'] = "Erreur lors de la mise à jour du trajet.";
      header("Location: /trajets/edit/$id");
    }
    exit;
  }


  // Supprime un trajet (propriétaire ou admin requis)
  public function destroy(int $id): void
  {
    // Vérifie que l'utilisateur est connecté
    if (!\App\Models\Auth::isLoggedIn()) {
      $_SESSION['error'] = "Vous devez être connecté.";
      header('Location: /login');
      exit;
    }

    $trajet = \App\Models\Trajet::find($id);
    if (!$trajet) {
      $_SESSION['error'] = "Trajet non trouvé.";
      header('Location: /trajets');
      exit;
    }

    // Vérifie que l'utilisateur est propriétaire ou admin
    if ($trajet['user_id'] !== $_SESSION['user_id'] && !\App\Models\Auth::isAdmin()) {
      $_SESSION['error'] = "Vous n'êtes pas autorisé à supprimer ce trajet.";
      header('Location: /trajets');
      exit;
    }

    if (\App\Models\Trajet::delete($id)) {
      $_SESSION['success'] = "Trajet supprimé avec succès !";
    } else {
      $_SESSION['error'] = "Erreur lors de la suppression.";
    }

    header('Location: /trajets');
    exit;
  }

  // Liste les trajets de l'utilisateur connecté (connecté requis)
  public function myTrajets(): void
  {
    AuthMiddleware::requireLogin();
    $trajets = Trajet::getByUser($_SESSION['user_id']);
    $this->render('trajets/my_trajets', [
      'title' => 'Mes trajets',
      'trajets' => $trajets
    ]);
  }

  // Méthode pour afficher le formulaire de contact du conducteur
  public function contact(int $id): void
  {
    $db = Database::getInstance();

    // Récupère les informations du trajet et du conducteur
    $trajet = $db->fetch(
      "SELECT
            t.id,
            CONCAT(u.prenom, ' ', u.nom) as conducteur,
            u.email as conducteur_email,
            ad.nom as agence_depart,
            aa.nom as agence_arrivee,
            t.date_depart
         FROM trajets t
         JOIN users u ON t.user_id = u.id
         JOIN agences ad ON t.agence_depart_id = ad.id
         JOIN agences aa ON t.agence_arrivee_id = aa.id
         WHERE t.id = ?",
      [$id]
    );

    if (!$trajet) {
      $_SESSION['error'] = "Trajet non trouvé.";
      header('Location: /');
      exit;
    }

    $this->render('trajets/contact', [
      'title' => 'Contacter le conducteur',
      'trajet' => $trajet
    ]);
  }

  public function sendMessage(int $id): void
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header('Location: /');
      exit;
    }

    if (!isset($_SESSION['user_id'])) {
      $_SESSION['error'] = "Vous devez être connecté pour envoyer un message.";
      header('Location: /login');
      exit;
    }

    $message = trim($_POST['message'] ?? '');

    if (empty($message)) {
      $_SESSION['error'] = "Le message ne peut pas être vide.";
      header("Location: /trajets/contact/$id");
      exit;
    }

    $db = Database::getInstance();

    // Récupère l'email du conducteur
    $trajet = $db->fetch(
      "SELECT u.email as conducteur_email, CONCAT(u.prenom, ' ', u.nom) as conducteur
         FROM trajets t
         JOIN users u ON t.user_id = u.id
         WHERE t.id = ?",
      [$id]
    );

    if (!$trajet) {
      $_SESSION['error'] = "Trajet non trouvé.";
      header('Location: /');
      exit;
    }

    // Récupère les informations de l'expéditeur
    $sender = $db->fetch(
      "SELECT CONCAT(prenom, ' ', nom) as nom, email
         FROM users
         WHERE id = ?",
      [$_SESSION['user_id']]
    );

    // Ici, tu pourrais envoyer un email ou enregistrer le message en base de données
    // Pour l'exemple, on simule l'envoi
    $_SESSION['success'] = "Votre message a été envoyé à {$trajet['conducteur']}.";
    header('Location: /');
    exit;
  }
}
