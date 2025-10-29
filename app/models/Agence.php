<?php

namespace App\Models;

use Core\Database;
use PDO;

class Agence
{
  // Récupère une agence par son ID
  public static function find(int $id): ?array
  {
    $db = Database::getInstance();
    return $db->fetch("SELECT * FROM agences WHERE id = ?", [$id]);
  }

  // Récupère toutes les agences
  public static function all(): array
  {
    $db = Database::getInstance();
    return $db->query("SELECT * FROM agences ORDER BY nom");
  }

  // Récupère les trajets associés à une agence
  public static function getTrajets(int $agenceId): array
  {
    $db = Database::getInstance();
    return $db->query(
      "SELECT
            t.*,
            CONCAT(u.prenom, ' ', u.nom) as conducteur,
            ad.nom as agence_depart,  -- Ajoute cette ligne
            aa.nom as agence_arrivee  -- Ajoute cette ligne
         FROM trajets t
         JOIN users u ON t.user_id = u.id
         JOIN agences ad ON t.agence_depart_id = ad.id
         JOIN agences aa ON t.agence_arrivee_id = aa.id
         WHERE t.agence_depart_id = ? OR t.agence_arrivee_id = ?
         ORDER BY t.date_depart",
      [$agenceId, $agenceId]
    );
  }

  // Crée une nouvelle agence (réservé aux admins)
  public static function create(string $nom, string $ville, string $adresse): bool
  {
    $db = Database::getInstance();
    return $db->execute(
      "INSERT INTO agences (nom, ville, adresse) VALUES (?, ?, ?)",
      [$nom, $ville, $adresse]
    );
  }

  // Met à jour une agence
  public static function update(int $id, string $nom, string $ville, string $adresse): bool
  {
    $db = Database::getInstance();
    return $db->execute(
      "UPDATE agences SET nom = ?, ville = ?, adresse = ? WHERE id = ?",
      [$nom, $ville, $adresse, $id]
    );
  }

  // Supprime une agence (réservé aux admins)
  public static function delete(int $id): bool
  {
    $db = Database::getInstance();
    return $db->execute("DELETE FROM agences WHERE id = ?", [$id]);
  }
}
