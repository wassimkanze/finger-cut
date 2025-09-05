# Finger's Cut - Système de Gestion de Production Audiovisuelle

## 🎬 Description

Finger's Cut est une application web Laravel développée pour la gestion interne d'une entreprise de production audiovisuelle. Le système permet aux administrateurs de gérer les employés, planifier les événements et assigner des tâches, tandis que les employés peuvent consulter leur planning personnel et gérer leurs missions.

## ✨ Fonctionnalités

### 🔐 Authentification et Autorisation
- Système d'authentification complet avec Laravel Breeze
- Gestion des rôles (Admin/Employé)
- Middleware de protection des routes
- Redirection automatique basée sur le rôle
- **Système de codes d'invitation** pour l'inscription sécurisée
- **Validation de mot de passe robuste** (majuscules, minuscules, chiffres, caractères spéciaux)
- **Modals d'inscription** intégrés dans l'interface

### 👥 Gestion des Utilisateurs
- **Dashboard Admin** avec statistiques complètes
- Gestion des utilisateurs (création, modification, désactivation)
- Anonymisation RGPD des comptes désactivés
- Système de contact entre admin et employés
- **Gestion des codes d'invitation** (génération, révocation, suivi)
- **Inscription contrôlée** avec validation en temps réel

### 📅 Planning et Événements
- **Interface de planning** avec FullCalendar
- Création, modification et suppression d'événements
- Détection de conflits d'emploi du temps
- Assignation d'employés aux événements
- Gestion des adresses complètes
- Statuts d'événements (planifié, en cours, terminé, annulé)

### 👨‍💼 Espace Employé
- **Dashboard personnel** avec statistiques
- **Planning personnel** avec calendrier interactif
- **Gestion des tâches** (à venir et terminées)
- **Profil utilisateur** avec modification des informations

### 🔔 Système de Notifications
- Notifications en temps réel
- Types : événement assigné, modifié, annulé, général
- Interface de notification avec Alpine.js
- Marquage comme lu/non lu

### 🎨 Interface Utilisateur
- Design moderne avec Tailwind CSS
- Interface responsive
- Animations et transitions fluides
- Modales interactives
- Site vitrine pour l'entreprise
- **Validation en temps réel** avec indicateurs visuels
- **Interface d'inscription optimisée** avec layout compact
- **Feedback utilisateur** avec bordures colorées et messages

## 🛠️ Technologies Utilisées

- **Backend** : Laravel 12 (PHP 8.2+)
- **Frontend** : Tailwind CSS + Alpine.js
- **Base de données** : SQLite (par défaut)
- **Calendrier** : FullCalendar
- **Authentification** : Laravel Breeze

## 📦 Installation

### Prérequis
- PHP 8.2 ou supérieur
- Composer
- Node.js et npm
- SQLite (ou MySQL/PostgreSQL)

### Étapes d'installation

1. **Cloner le projet**
```bash
git clone <repository-url>
cd fingers-cut
```

2. **Installer les dépendances PHP**
```bash
composer install
```

3. **Installer les dépendances Node.js**
```bash
npm install
```

4. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configuration de la base de données**
Modifiez le fichier `.env` pour configurer votre base de données :
```env
DB_CONNECTION=sqlite
DB_DATABASE=/chemin/vers/database/database.sqlite
```

6. **Exécuter les migrations**
```bash
php artisan migrate
```

7. **Créer des données de test (optionnel)**
```bash
php artisan db:seed --class=TestDataSeeder
```

8. **Compiler les assets**
```bash
npm run build
```

9. **Démarrer le serveur**
```bash
php artisan serve
```

## 👤 Comptes de Test

### Administrateur
- **Email** : admin@fingerscut.com
- **Mot de passe** : password

### Employés
- **Email** : marie.dubois@fingerscut.com
- **Mot de passe** : password

- **Email** : pierre.martin@fingerscut.com
- **Mot de passe** : password

## 🔐 Codes d'Invitation de Test

### Code Universel (Tous emails)
- **Code** : `DEMO2024`
- **Rôle** : employé
- **Expire le** : 05/10/2025

### Code Spécifique
- **Code** : `MODAL2024`
- **Rôle** : employé
- **Expire le** : 05/10/2025

## 🚀 Utilisation

### Pour les Administrateurs

1. **Dashboard** : Vue d'ensemble des utilisateurs et statistiques
2. **Gestion des utilisateurs** : Créer, modifier, désactiver les comptes
3. **Planning** : Créer et gérer les événements
4. **Assignation** : Assigner des employés aux événements
5. **Codes d'invitation** : Générer et gérer les codes d'accès
6. **Sécurité** : Contrôler l'inscription des nouveaux utilisateurs

### Pour les Employés

1. **Dashboard** : Vue personnalisée avec statistiques
2. **Planning** : Consulter les événements assignés
3. **Tâches** : Gérer les missions à venir et terminées
4. **Profil** : Modifier les informations personnelles

### Pour les Nouveaux Utilisateurs

1. **Inscription** : Utiliser un code d'invitation valide
2. **Validation** : Respecter les critères de mot de passe sécurisé
3. **Confirmation** : Vérifier la correspondance des mots de passe
4. **Feedback** : Suivre les indicateurs de validation en temps réel

## 📁 Structure du Projet

```
fingers-cut/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminController.php      # Gestion admin
│   │   ├── EmployeeController.php   # Gestion employés
│   │   ├── NotificationController.php # Notifications
│   │   └── Auth/
│   │       └── RegisteredUserController.php # Inscription sécurisée
│   ├── Models/
│   │   ├── User.php                 # Modèle utilisateur
│   │   ├── Event.php                # Modèle événement
│   │   ├── Notification.php         # Modèle notification
│   │   └── InvitationCode.php       # Modèle codes d'invitation
│   └── Rules/
│       └── StrongPassword.php       # Validation mot de passe
├── database/
│   ├── migrations/                  # Migrations de base de données
│   └── seeders/                     # Seeders pour données de test
├── resources/
│   └── views/
│       ├── admin/                   # Vues admin
│       ├── employee/                # Vues employé
│       ├── auth/                    # Vues d'authentification
│       ├── components/              # Composants réutilisables
│       └── home.blade.php           # Page d'accueil avec modals
└── routes/
    └── web.php                      # Routes de l'application
```

## 🔧 Configuration Avancée

### Base de données
Pour utiliser MySQL ou PostgreSQL, modifiez le fichier `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fingers_cut
DB_USERNAME=root
DB_PASSWORD=
```

### Notifications par Email
Pour activer les notifications par email, configurez les paramètres SMTP dans `.env` :
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

## 🧪 Tests

```bash
# Exécuter les tests
php artisan test

# Tests avec couverture
php artisan test --coverage
```

## 🔒 Sécurité

### Codes d'Invitation
- **Génération sécurisée** : Codes uniques et aléatoires
- **Expiration** : Codes avec date d'expiration configurable
- **Usage unique** : Chaque code ne peut être utilisé qu'une fois
- **Rôles assignés** : Attribution automatique du rôle lors de l'inscription
- **Traçabilité** : Suivi de qui a créé et utilisé chaque code

### Validation des Mots de Passe
- **Critères stricts** : 8+ caractères, majuscules, minuscules, chiffres, caractères spéciaux
- **Validation en temps réel** : Feedback immédiat pendant la saisie
- **Confirmation obligatoire** : Vérification de correspondance des mots de passe
- **Interface intuitive** : Indicateurs visuels clairs (✓/✗)

### Interface d'Inscription
- **Modals intégrés** : Pas de redirection vers des pages externes
- **Layout optimisé** : Interface compacte et responsive
- **Validation côté client** : Prévention de soumission invalide
- **Messages d'erreur** : Feedback clair et précis

## 📝 API

L'application expose une API REST pour les notifications :

- `GET /notifications` - Liste des notifications
- `PATCH /notifications/{id}/read` - Marquer comme lu
- `PATCH /notifications/mark-all-read` - Tout marquer comme lu
- `DELETE /notifications/{id}` - Supprimer une notification
- `GET /notifications/unread-count` - Nombre de notifications non lues

### API Codes d'Invitation (Admin)
- `GET /admin/invitation-codes` - Liste des codes d'invitation
- `POST /admin/invitation-codes` - Créer un nouveau code
- `DELETE /admin/invitation-codes/{id}` - Révoker un code

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 📞 Support

Pour toute question ou problème, contactez l'équipe de développement.

---

**Finger's Cut** - Créons ensemble des histoires visuelles qui captivent et inspirent 🎬✨