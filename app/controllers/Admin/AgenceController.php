<?php
namespace App\Controllers\Admin;

use App\Models\Agence;
use Core\Controller;
use Core\Middleware\AdminMiddleware;

class AgenceController extends Controller
{
    public function index(): void
    {
        AdminMiddleware::requireAdmin();
        $agences = Agence::all();
        $this->render('admin/agences/index', [
            'title' => 'Gestion des agences',
            'agences' => $agences
        ]);
    }

    public function create(): void
    {
        AdminMiddleware::requireAdmin();
        $this->render('admin/agences/create', [
            'title' => 'Créer une agence'
        ]);
    }

    public function store(): void
    {
        AdminMiddleware::requireAdmin();

        $nom = trim($_POST['nom'] ?? '');
        $ville = trim($_POST['ville'] ?? '');
        $adresse = trim($_POST['adresse'] ?? '');

        $errors = [];
        if (empty($nom)) $errors['nom'] = "Le nom est obligatoire.";
        if (empty($ville)) $errors['ville'] = "La ville est obligatoire.";

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: /admin/agences/create');
            exit;
        }

        if (Agence::create($nom, $ville, $adresse)) {
            $_SESSION['success'] = "Agence créée avec succès !";
            header('Location: /admin/agences');
        } else {
            $_SESSION['error'] = "Erreur lors de la création de l'agence.";
            header('Location: /admin/agences/create');
        }
        exit;
    }

    public function edit(int $id): void
    {
        AdminMiddleware::requireAdmin();
        $agence = Agence::find($id);
        if (!$agence) {
            $_SESSION['error'] = "Agence non trouvée.";
            header('Location: /admin/agences');
            exit;
        }
        $this->render('admin/agences/edit', [
            'title' => "Modifier l'agence",
            'agence' => $agence
        ]);
    }

    public function update(int $id): void
    {
        AdminMiddleware::requireAdmin();

        $nom = trim($_POST['nom'] ?? '');
        $ville = trim($_POST['ville'] ?? '');
        $adresse = trim($_POST['adresse'] ?? '');

        $errors = [];
        if (empty($nom)) $errors['nom'] = "Le nom est obligatoire.";
        if (empty($ville)) $errors['ville'] = "La ville est obligatoire.";

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header("Location: /admin/agences/edit/$id");
            exit;
        }

        if (Agence::update($id, $nom, $ville, $adresse)) {
            $_SESSION['success'] = "Agence mise à jour avec succès !";
            header("Location: /admin/agences/show/$id");
        } else {
            $_SESSION['error'] = "Erreur lors de la mise à jour de l'agence.";
            header("Location: /admin/agences/edit/$id");
        }
        exit;
    }

    public function destroy(int $id): void
    {
        AdminMiddleware::requireAdmin();

        if (Agence::delete($id)) {
            $_SESSION['success'] = "Agence supprimée avec succès !";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression de l'agence.";
        }
        header('Location: /admin/agences');
        exit;
    }
}
