<?php

namespace App\Controllers;

use App\Models\Auth;
use App\Models\User;
use Core\Controller;

class AuthController extends Controller
{
  // Affiche le formulaire de connexion
  public function login(): void
  {
    if (Auth::isLoggedIn()) {
      header('Location: /');
      exit;
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
      $this->render('auth/login', [
        'title' => 'Connexion',
        'email' => $email,
        'error' => "L'email et le mot de passe sont obligatoires."
      ]);
      return; // On ne fait PAS de redirection
    }
  }

  // Traite la soumission du formulaire de connexion
  public function loginPost(): void
  {
    // Si déjà connecté, redirige vers l'accueil
    if (Auth::isLoggedIn()) {
      header('Location: /');
      exit;
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validation des champs
    if (empty($email) || empty($password)) {
      $_SESSION['error'] = "L'email et le mot de passe sont obligatoires.";
      $this->render('auth/login', [
        'title' => 'Connexion',
        'email' => $email,
        'error' => $_SESSION['error']
      ]);
      unset($_SESSION['error']);
      return;
    }

    // Tentative de connexion
    $user = Auth::login($email, $password);

    if ($user) {
      $_SESSION['success'] = "Connexion réussie !";
      header('Location: /');
      exit;
    } else {
      $_SESSION['error'] = "Email ou mot de passe incorrect.";
      $this->render('auth/login', [
        'title' => 'Connexion',
        'email' => $email,
        'error' => $_SESSION['error']
      ]);
      unset($_SESSION['error']);
    }
  }

  // Affiche le formulaire d'inscription
  public function register(): void
  {
    if (Auth::isLoggedIn()) {
      header('Location: /');
      exit;
    }

    $this->render('auth/register', [
      'title' => 'Inscription',
      'nom' => $_POST['nom'] ?? '',
      'prenom' => $_POST['prenom'] ?? '',
      'email' => $_POST['email'] ?? ''
    ]);
  }

  // Traite la soumission du formulaire d'inscription
  public function registerPost(): void
  {
    if (Auth::isLoggedIn()) {
      header('Location: /');
      exit;
    }

    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';

    // Validation des champs
    $errors = [];
    if (empty($nom)) $errors['nom'] = "Le nom est obligatoire.";
    if (empty($prenom)) $errors['prenom'] = "Le prénom est obligatoire.";
    if (empty($email)) $errors['email'] = "L'email est obligatoire.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "L'email n'est pas valide.";
    if (empty($password)) $errors['password'] = "Le mot de passe est obligatoire.";
    if ($password !== $passwordConfirm) $errors['password_confirm'] = "Les mots de passe ne correspondent pas.";
    if (strlen($password) < 6) $errors['password'] = "Le mot de passe doit faire au moins 6 caractères.";

    if (User::emailExists($email)) {
      $errors['email'] = "Un compte existe déjà avec cet email.";
    }

    if (!empty($errors)) {
      $this->render('auth/register', [
        'title' => 'Inscription',
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'errors' => $errors
      ]);
      return;
    }

    // Création de l'utilisateur
    if (User::create($nom, $prenom, $email, $password)) {
      $_SESSION['success'] = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
      header('Location: /login');
      exit;
    } else {
      $_SESSION['error'] = "Erreur lors de la création du compte.";
      $this->render('auth/register', [
        'title' => 'Inscription',
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'error' => $_SESSION['error']
      ]);
      unset($_SESSION['error']);
    }
  }

  // Déconnecte l'utilisateur
  public function logout(): void
  {
    Auth::logout();
    $_SESSION['success'] = "Vous êtes maintenant déconnecté.";
    header('Location: /');
    exit;
  }
}
