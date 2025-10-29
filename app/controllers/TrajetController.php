<?php

namespace App\Controllers;

use Core\Controller;
use Core\Database;
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
