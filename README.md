# 🚗 Klaxon - Plateforme de Covoiturage Inter-Agences

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%208.0-blue)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-Educational-green)](LICENSE)

Klaxon est une application web PHP MVC moderne permettant la gestion collaborative des trajets de covoiturage entre agences. Développée avec une architecture MVC personnalisée, elle offre une interface intuitive et responsive, un système de gestion des rôles avancé, et des fonctionnalités complètes pour faciliter le covoiturage professionnel.

## 📋 Table des matières

- [Fonctionnalités](#-fonctionnalités)
- [Technologies](#-technologies)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Utilisation](#-utilisation)
- [Structure du projet](#-structure-du-projet)
- [Identifiants de test](#-identifiants-de-test)
- [Sécurité](#-sécurité)
- [Licence](#-licence)

## ✨ Fonctionnalités

### Gestion des utilisateurs
- ✅ Inscription et connexion sécurisées
- ✅ Système de rôles (Utilisateur / Administrateur)
- ✅ CRUD complet pour les utilisateurs (admin)
- ✅ Profils utilisateurs personnalisables

### Gestion des agences
- ✅ Création, modification et suppression d'agences (admin)
- ✅ Consultation publique des agences
- ✅ Association des trajets aux agences

### Gestion des trajets
- ✅ Création et publication de trajets
- ✅ Modification et suppression des trajets
- ✅ Système de filtrage avancé (date, agence, destination)
- ✅ Pagination intelligente
- ✅ Recherche de trajets disponibles
- ✅ Formulaire de contact intégré pour contacter les conducteurs

### Administration
- 📊 Tableau de bord avec statistiques en temps réel
- 📈 Nombre d'agences, trajets et utilisateurs
- 🛡️ Protection des routes sensibles
- 🔐 Validation des permissions par rôle

### Interface utilisateur
- 📱 Design responsive (Bootstrap 5)
- 🎨 Interface moderne et intuitive
- 🔍 Navigation fluide et ergonomique
- ⚠️ Pages d'erreur personnalisées (404, 403)

## 🛠 Technologies

- **Backend** : PHP 8.0+, Architecture MVC personnalisée
- **Base de données** : MySQL / MariaDB, PDO
- **Frontend** : Bootstrap 5, Bootstrap Icons, SCSS
- **Gestion des dépendances** : Composer (PSR-4)
- **Sécurité** : Middleware d'authentification et d'autorisation

## 📦 Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- PHP >= 8.0
- MySQL ou MariaDB
- Composer
- Un serveur web (Apache, Nginx) ou le serveur PHP intégré

## 🚀 Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/jeanniot-wdv/klaxon-app.git
cd klaxon-app
```

### 2. Installer les dépendances

```bash
composer install
```

### 3. Configurer la base de données

#### Créer la base de données

```sql
CREATE DATABASE klaxon-app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Configurer les paramètres de connexion

Modifiez le fichier `config/database.php` avec vos paramètres de connexion :

```php
return [
    'host' => 'localhost',
    'dbname' => 'klaxon-app',
    'username' => 'votre_utilisateur',
    'password' => 'votre_mot_de_passe',
    'charset' => 'utf8mb4'
];
```

#### Importer le schéma

Importez le fichier SQL fourni dans votre base de données :

```bash
mysql -u votre_utilisateur -p klaxon-app < _database/schema.sql
mysql -u votre_utilisateur -p klaxon-app < _database/insert_datas.sql
```

### 4. Démarrer le serveur

#### Serveur PHP intégré (développement)

```bash
php -S localhost:8000 -t public
```

### 5. Accéder à l'application

Ouvrez votre navigateur et accédez à :
- **Serveur PHP intégré** : `http://localhost:8000`

## 🔧 Configuration

### Variables d'environnement

Les paramètres principaux de l'application peuvent être configurés dans le dossier `config/` :

- `config/database.php` - Configuration de la base de données

## 📖 Utilisation

### Pour les utilisateurs

1. **S'inscrire** : Créez un compte utilisateur depuis la page d'inscription
2. **Se connecter** : Authentifiez-vous avec vos identifiants
3. **Consulter les trajets** : Parcourez les trajets disponibles avec les filtres
4. **Créer un trajet** : Proposez un covoiturage en renseignant les informations
5. **Contacter un conducteur** : Utilisez le formulaire de contact pour réserver une place

### Pour les administrateurs

1. **Tableau de bord** : Accédez aux statistiques globales
2. **Gestion des utilisateurs** : Créez, modifiez ou supprimez des comptes
3. **Gestion des agences** : Administrez la liste des agences
4. **Gestion des trajets** : Modérez et gérez tous les trajets
5. **Surveillance** : Consultez les statistiques d'utilisation

## 📁 Structure du projet

```
klaxon-app/
├── app/
│   ├── controllers/       # Contrôleurs MVC (logique métier)
│   ├── models/            # Modèles (accès base de données)
│   └── views/             # Vues (templates HTML/PHP)
├── config/                # Fichiers de configuration
│   ├── database.php       # Configuration BDD
│   └── app.php            # Configuration application
├── core/                  # Classes principales du framework
│   ├── Router.php         # Gestionnaire de routes
│   ├── Controller.php     # Contrôleur de base
│   ├── Database.php       # Connexion PDO
│   └── Middleware/        # Middlewares (Auth, Admin)
├── public/                # Point d'entrée public
│   ├── index.php          # Bootstrap de l'application
│   └── assets/            # Ressources statiques (CSS, JS, images)
├── vendor/                # Dépendances Composer
├── composer.json          # Configuration Composer et autoload PSR-4
├── .gitignore             # Fichiers ignorés par Git
└── README.md              # Documentation
```

## 🔑 Identifiants de test

### Compte utilisateur standard

```
Email : user@klaxon.fr
Mot de passe : user123
```

### Compte administrateur

```
Email : admin@klaxon.fr
Mot de passe : admin
```

> ⚠️ **Important** : Modifiez ces identifiants en production pour garantir la sécurité.

## 🔒 Sécurité

Klaxon intègre plusieurs mécanismes de sécurité :

- **Protection des routes** : Middleware d'authentification (`AuthMiddleware`)
- **Gestion des rôles** : Middleware d'autorisation (`AdminMiddleware`)
- **Validation des formulaires** : Validation côté serveur et client
- **Préparation des requêtes** : Utilisation de PDO avec requêtes préparées
- **Hashage des mots de passe** : Utilisation de `password_hash()` et `password_verify()`

## 📄 Licence

Ce projet est développé à des fins éducatives et est libre d'utilisation. Vous pouvez le modifier et le distribuer selon vos besoins.

## 📞 Contact

Pour toute question ou suggestion :

- 🐙 GitHub : [jeanniot-wdv](https://github.com/jeanniot-wdv)
