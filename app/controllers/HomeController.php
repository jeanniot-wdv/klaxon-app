<?php
namespace App\Controllers;

use Core\Controller;
use Core\Database;

class HomeController extends Controller
{
  public function index(): void
  {
    $db = Database::getInstance();

    // Récupère les 6 dernières agences ajoutées
    $agences = $db->query(
      "SELECT id, nom, ville FROM agences ORDER BY created_at DESC LIMIT 6"
    );

    // Récupère les 5 derniers trajets disponibles avec les commentaires
    $trajets = $db->query(
      "SELECT
            t.id,
            CONCAT(u.prenom, ' ', u.nom) as conducteur,
            ad.nom as agence_depart,
            aa.nom as agence_arrivee,
            t.date_depart,
            t.places_disponibles,
            t.commentaire
         FROM trajets t
         JOIN users u ON t.user_id = u.id
         JOIN agences ad ON t.agence_depart_id = ad.id
         JOIN agences aa ON t.agence_arrivee_id = aa.id
         WHERE t.date_depart > NOW()
         ORDER BY t.date_depart ASC
         LIMIT 5"
    );

    $stats = [
      'agences' => $db->fetch("SELECT COUNT(*) as count FROM agences")['count'],
      'trajets'  => $db->fetch("SELECT COUNT(*) as count FROM trajets")['count'],
      'users'    => $db->fetch("SELECT COUNT(*) as count FROM users")['count']
    ];

    $this->render('home/index', [
      'title'   => 'Bienvenue sur Klaxon - Covoiturage',
      'agences' => $agences,
      'trajets'  => $trajets,
      'stats'   => $stats
    ]);
  }
}
