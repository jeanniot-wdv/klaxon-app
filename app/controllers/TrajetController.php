<?php
// app/controllers/TrajetController.php
namespace App\Controllers;

use Core\Controller;
use Core\Database;

class TrajetController extends Controller
{
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
