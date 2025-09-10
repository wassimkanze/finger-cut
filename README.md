# Finger's Cut - Système de Gestion d'Événements

## Description

Finger's Cut est une application web développée avec Laravel pour la gestion d'événements d'une agence de production audiovisuelle. Le système permet aux administrateurs de gérer les employés et planifier les événements, tandis que les employés peuvent consulter leur planning et gérer leurs tâches.

## Fonctionnalités

### Authentification et Sécurité
- Système d'authentification avec Laravel Breeze
- Gestion des rôles (Admin/Employé)
- Codes d'invitation pour l'inscription sécurisée
- Validation de mots de passe robuste
- Modals d'inscription intégrés

### Gestion des Utilisateurs
- Dashboard admin avec statistiques
- Gestion des utilisateurs (création, modification, désactivation)
- Système de codes d'invitation
- Anonymisation RGPD des comptes désactivés

### Planning et Événements
- Interface de planning avec FullCalendar
- Création, modification et suppression d'événements
- Détection de conflits d'emploi du temps
- Assignation d'employés aux événements
- Gestion des statuts d'événements

### Espace Employé
- Dashboard personnel
- Planning personnel avec calendrier
- Gestion des tâches
- Profil utilisateur

### Messages de Contact
- Formulaire de contact fonctionnel
- Système d'archivage des messages
- Interface admin pour gérer les demandes
- Filtres par statut et type de projet

## Technologies

- **Backend** : Laravel 12 (PHP 8.2+)
- **Frontend** : Tailwind CSS + Alpine.js
- **Base de données** : SQLite
- **Calendrier** : FullCalendar
- **Authentification** : Laravel Breeze

## Installation

### Prérequis
- PHP 8.2+
- Composer
- Node.js et npm

### Étapes

1. **Cloner le projet**
```bash
git clone <repository-url>
cd fingers-cut
```

2. **Installer les dépendances**
```bash
composer install
npm install
```

3. **Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Base de données**
```bash
php artisan migrate
php artisan db:seed --class=TestDataSeeder
```

5. **Compiler les assets**
```bash
npm run build
```

6. **Démarrer le serveur**
```bash
php artisan serve
```

## Comptes de Test

### Administrateur
- **Email** : admin@fingerscut.com
- **Mot de passe** : password

### Codes d'Invitation
- **Code** : `DEMO2024`
- **Rôle** : employé
- **Expire le** : 05/10/2025

## Structure du Projet

```
fingers-cut/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminController.php
│   │   ├── EmployeeController.php
│   │   └── ContactController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Event.php
│   │   └── ContactMessage.php
│   └── Rules/
│       └── StrongPassword.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── admin/
│   ├── employee/
│   └── home.blade.php
└── routes/web.php
```

## Utilisation

### Administrateur
1. **Dashboard** : Vue d'ensemble des statistiques
2. **Gestion des utilisateurs** : Créer et gérer les comptes
3. **Planning** : Créer et gérer les événements
4. **Codes d'invitation** : Générer des codes d'accès
5. **Messages de contact** : Gérer les demandes clients

### Employé
1. **Dashboard** : Vue personnalisée
2. **Planning** : Consulter les événements assignés
3. **Tâches** : Gérer les missions
4. **Profil** : Modifier les informations

## Tests

```bash
php artisan test
```

## Sécurité

- Codes d'invitation uniques et expirants
- Validation de mots de passe stricte
- Protection CSRF
- Middleware d'authentification et d'autorisation
- Anonymisation RGPD des données

## API

L'application expose des endpoints pour :
- Gestion des notifications
- Gestion des codes d'invitation
- Gestion des messages de contact

## Licence

Ce projet est sous licence MIT.

---

**Finger's Cut** - Système de gestion d'événements pour agence de production audiovisuelle