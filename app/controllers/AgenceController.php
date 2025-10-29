<?php
namespace App\Controllers;

use App\Models\Agence;
use App\Models\User;
use Core\Controller;

class AgenceController extends Controller
{
    // Affiche une agence
    public function show(int $id): void
    {
        $agence = Agence::find($id);
        if (!$agence) {
            header("HTTP/1.0 404 Not Found");
            $this->render('errors/404', ['message' => 'Agence non trouvée']);
            return;
        }

        $trajets = Agence::getTrajets($id);
        $this->render('agences/show', [
            'title'  => "Détails de l'agence " . htmlspecialchars($agence['nom']),
            'agence' => $agence,
            'trajets' => $trajets
        ]);
    }

    // Liste toutes les agences
    public function index(): void
    {
        $agences = Agence::all();
        $this->render('agences/index', [
            'title'   => 'Liste des agences',
            'agences' => $agences
        ]);
    }

    // Affiche le formulaire de création (réservé aux admins)
    public function create(): void
    {
        if (!isset($_SESSION['user_id']) || !User::isAdmin($_SESSION['user_id'])) {
            $_SESSION['error'] = "Accès refusé.";
            header('Location: /');
            exit;
        }

        $this->render('agences/create', ['title' => 'Créer une agence']);
    }

    // Traite la création d'une agence
    public function store(): void
    {
        if (!isset($_SESSION['user_id']) || !User::isAdmin($_SESSION['user_id'])) {
            $_SESSION['error'] = "Accès refusé.";
            header('Location: /');
            exit;
        }

        $nom = trim($_POST['nom'] ?? '');
        $ville = trim($_POST['ville'] ?? '');
        $adresse = trim($_POST['adresse'] ?? '');

        if (empty($nom) || empty($ville)) {
            $_SESSION['error'] = "Le nom et la ville sont obligatoires.";
            header('Location: /agences/create');
            exit;
        }

        if (Agence::create($nom, $ville, $adresse)) {
            $_SESSION['success'] = "Agence créée avec succès !";
            header('Location: /agences');
        } else {
            $_SESSION['error'] = "Erreur lors de la création.";
            header('Location: /agences/create');
        }
        exit;
    }

    // Affiche le formulaire de modification (réservé aux admins)
    public function edit(int $id): void
    {
        if (!isset($_SESSION['user_id']) || !User::isAdmin($_SESSION['user_id'])) {
            $_SESSION['error'] = "Accès refusé.";
            header('Location: /');
            exit;
        }

        $agence = Agence::find($id);
        if (!$agence) {
            $_SESSION['error'] = "Agence non trouvée.";
            header('Location: /agences');
            exit;
        }

        $this->render('agences/edit', [
            'title'  => "Modifier l'agence",
            'agence' => $agence
        ]);
    }

    // Traite la modification d'une agence
    public function update(int $id): void
    {
        if (!isset($_SESSION['user_id']) || !User::isAdmin($_SESSION['user_id'])) {
            $_SESSION['error'] = "Accès refusé.";
            header('Location: /');
            exit;
        }

        $nom = trim($_POST['nom'] ?? '');
        $ville = trim($_POST['ville'] ?? '');
        $adresse = trim($_POST['adresse'] ?? '');

        if (empty($nom) || empty($ville)) {
            $_SESSION['error'] = "Le nom et la ville sont obligatoires.";
            header("Location: /agences/edit/$id");
            exit;
        }

        if (Agence::update($id, $nom, $ville, $adresse)) {
            $_SESSION['success'] = "Agence mise à jour !";
            header("Location: /agences/$id");
        } else {
            $_SESSION['error'] = "Erreur lors de la mise à jour.";
            header("Location: /agences/edit/$id");
        }
        exit;
    }

    // Supprime une agence (réservé aux admins)
    public function destroy(int $id): void
    {
        if (!isset($_SESSION['user_id']) || !User::isAdmin($_SESSION['user_id'])) {
            $_SESSION['error'] = "Accès refusé.";
            header('Location: /');
            exit;
        }

        if (Agence::delete($id)) {
            $_SESSION['success'] = "Agence supprimée avec succès !";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression.";
        }
        header('Location: /agences');
        exit;
    }
}
