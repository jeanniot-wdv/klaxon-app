<?php

namespace App\Controllers\Admin;

use App\Models\Auth;
use App\Models\User;
use Core\Controller;
use Core\Middleware\AdminMiddleware;

class UserController extends Controller
{
  // Affiche la liste des utilisateurs
  public function index(): void
  {
    AdminMiddleware::requireAdmin();
    $users = User::all();
    $this->render('admin/users/index', [
      'title' => 'Gestion des utilisateurs',
      'users' => $users
    ]);
  }

  // Affiche les détails d'un utilisateur
  public function show(int $id): void
  {
    AdminMiddleware::requireAdmin();
    $user = User::find($id);
    if (!$user) {
      $_SESSION['error'] = "Utilisateur non trouvé.";
      header('Location: /admin/users');
      exit;
    }
    $this->render('admin/users/show', [
      'title' => "Détails de l'utilisateur",
      'user' => $user
    ]);
  }

  public function create(): void
  {
    AdminMiddleware::requireAdmin();
    $this->render('admin/users/create', [
      'title' => 'Créer un utilisateur'
    ]);
  }

  public function store(): void
  {
    AdminMiddleware::requireAdmin();

    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    $errors = [];
    if (empty($nom)) $errors['nom'] = "Le nom est obligatoire.";
    if (empty($prenom)) $errors['prenom'] = "Le prénom est obligatoire.";
    if (empty($email)) $errors['email'] = "L'email est obligatoire.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "L'email n'est pas valide.";
    if (empty($password)) $errors['password'] = "Le mot de passe est obligatoire.";
    if (strlen($password) < 6) $errors['password'] = "Le mot de passe doit faire au moins 6 caractères.";
    if (User::emailExists($email)) $errors['email'] = "Un compte existe déjà avec cet email.";

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
      $_SESSION['old_input'] = $_POST;
      header('Location: /admin/users/create');
      exit;
    }

    if (User::create($nom, $prenom, $email, $password, $role)) {
      $_SESSION['success'] = "Utilisateur créé avec succès !";
      header('Location: /admin/users');
    } else {
      $_SESSION['error'] = "Erreur lors de la création de l'utilisateur.";
      header('Location: /admin/users/create');
    }
    exit;
  }

  public function edit(int $id): void
  {
    AdminMiddleware::requireAdmin();
    $user = User::find($id);
    if (!$user) {
      $_SESSION['error'] = "Utilisateur non trouvé.";
      header('Location: /admin/users');
      exit;
    }
    $this->render('admin/users/edit', [
      'title' => "Modifier l'utilisateur",
      'user' => $user
    ]);
  }

  public function update(int $id): void
  {
    AdminMiddleware::requireAdmin();
    // Récupération des données du formulaire
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'user';
    $password = !empty($_POST['password']) ? $_POST['password'] : null;

    $user = User::find($id);
    if (!$user) {
      $_SESSION['error'] = "Utilisateur non trouvé.";
      header('Location: /admin/users');
      exit;
    }
    // Validation des données
    $errors = [];
    if (empty($nom)) $errors['nom'] = "Le nom est obligatoire.";
    if (empty($prenom)) $errors['prenom'] = "Le prénom est obligatoire.";
    if (empty($email)) $errors['email'] = "L'email est obligatoire.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "L'email n'est pas valide.";
    if ($email !== $user['email'] && User::emailExists($email)) $errors['email'] = "Un compte existe déjà avec cet email.";
    if ($password && strlen($password) < 6) $errors['password'] = "Le mot de passe doit faire au moins 6 caractères.";

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
      $_SESSION['old_input'] = $_POST;
      header("Location: /admin/users/edit/$id");
      exit;
    }
    // Mise à jour de l'utilisateur
    if (User::update($id, $nom, $prenom, $email, $password, $role)) {
      $_SESSION['success'] = "Utilisateur mis à jour avec succès !";
      header("Location: /admin/users/show/$id");
    } else {
      $_SESSION['error'] = "Erreur lors de la mise à jour de l'utilisateur.";
      header("Location: /admin/users/edit/$id");
    }
    exit;
  }

  public function destroy(int $id): void
  {
    AdminMiddleware::requireAdmin();

    if ($id === $_SESSION['user_id']) {
      $_SESSION['error'] = "Vous ne pouvez pas supprimer votre propre compte.";
      header('Location: /admin/users');
      exit;
    }

    if (User::delete($id)) {
      $_SESSION['success'] = "Utilisateur supprimé avec succès !";
    } else {
      $_SESSION['error'] = "Erreur lors de la suppression de l'utilisateur.";
    }
    header('Location: /admin/users');
    exit;
  }
}
