<?php
namespace App\Models;

use Core\Database;

class Trajet
{
    // Récupère un trajet par son ID
    public static function find(int $id): ?array
    {
        $db = Database::getInstance();
        return $db->fetch(
            "SELECT t.*, CONCAT(u.prenom, ' ', u.nom) as conducteur
             FROM trajets t
             JOIN users u ON t.user_id = u.id
             WHERE t.id = ?",
            [$id]
        );
    }

    // Vérifie si l'utilisateur est autorisé à modifier/supprimer un trajet
    public static function isOwner(int $trajetId, int $userId): bool
    {
        $db = Database::getInstance();
        $trajet = $db->fetch("SELECT user_id FROM trajets WHERE id = ?", [$trajetId]);
        return $trajet && ($trajet['user_id'] === $userId);
    }

    // Crée un nouveau trajet (réservé aux utilisateurs connectés)
    public static function create(
        int $userId,
        int $agenceDepartId,
        int $agenceArriveeId,
        string $dateDepart,
        string $dateArrivee,
        int $placesDisponibles,
        ?string $commentaire
    ): bool {
        $db = Database::getInstance();
        return $db->execute(
            "INSERT INTO trajets
             (user_id, agence_depart_id, agence_arrivee_id, date_depart, date_arrivee, places_disponibles, commentaire)
             VALUES (?, ?, ?, ?, ?, ?, ?)",
            [$userId, $agenceDepartId, $agenceArriveeId, $dateDepart, $dateArrivee, $placesDisponibles, $commentaire]
        );
    }

    // Met à jour un trajet
    public static function update(
        int $id,
        int $agenceDepartId,
        int $agenceArriveeId,
        string $dateDepart,
        string $dateArrivee,
        int $placesDisponibles,
        ?string $commentaire
    ): bool {
        $db = Database::getInstance();
        return $db->execute(
            "UPDATE trajets
             SET agence_depart_id = ?, agence_arrivee_id = ?, date_depart = ?,
                 date_arrivee = ?, places_disponibles = ?, commentaire = ?
             WHERE id = ?",
            [$agenceDepartId, $agenceArriveeId, $dateDepart, $dateArrivee, $placesDisponibles, $commentaire, $id]
        );
    }

    // Supprime un trajet
    public static function delete(int $id): bool
    {
        $db = Database::getInstance();
        return $db->execute("DELETE FROM trajets WHERE id = ?", [$id]);
    }

    // Récupère les trajets de l'utilisateur
    public static function getByUser(int $userId): array
    {
        $db = Database::getInstance();
        return $db->query(
            "SELECT t.*, ad.nom as agence_depart, aa.nom as agence_arrivee
             FROM trajets t
             JOIN agences ad ON t.agence_depart_id = ad.id
             JOIN agences aa ON t.agence_arrivee_id = aa.id
             WHERE t.user_id = ?
             ORDER BY t.date_depart",
            [$userId]
        );
    }
}
