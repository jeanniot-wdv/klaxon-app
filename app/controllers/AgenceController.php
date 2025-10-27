<?php

namespace App\Controllers;

use Core\Controller;
use Core\Database;

class AgenceController extends Controller
{
  // Méthode pour afficher une agence spécifique
  public function show(int $id): void
  {
    $db = Database::getInstance();

    // Récupère les détails de l'agence
    $agence = $db->fetch(
      "SELECT id, nom, ville, adresse FROM agences WHERE id = ?",
      [$id]
    );

    if (!$agence) {
      // Gère le cas où l'agence n'existe pas
      header("HTTP/1.0 404 Not Found");
      $this->render('errors/404', ['message' => 'Agence non trouvée']);
      return;
    }

    // Récupère les trajets associés à cette agence (exemple)
    $trajets = $db->query(
      "SELECT
                t.id,
                CONCAT(u.prenom, ' ', u.nom) as conducteur,
                ad.nom as agence_depart,
                aa.nom as agence_arrivee,
                t.date_depart,
                t.places_disponibles
             FROM trajets t
             JOIN users u ON t.user_id = u.id
             JOIN agences ad ON t.agence_depart_id = ad.id
             JOIN agences aa ON t.agence_arrivee_id = aa.id
             WHERE t.agence_depart_id = ? OR t.agence_arrivee_id = ?
             ORDER BY t.date_depart ASC",
      [$id, $id]
    );

    $this->render('agences/show', [
      'title'  => "Détails de l'agence " . htmlspecialchars($agence['nom']),
      'agence' => $agence,
      'trajets' => $trajets
    ]);
  }
  // Méthode pour afficher la liste des agences
  public function index(): void
  {
    $db = Database::getInstance();
    $agences = $db->query("SELECT id, nom, ville FROM agences ORDER BY nom");

    $this->render('agences/index', [
      'title'   => 'Liste des agences',
      'agences' => $agences
    ]);
  }
}
