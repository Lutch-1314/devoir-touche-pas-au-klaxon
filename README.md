# Touche pas au klaxon

## Présentation

**Touche pas au klaxon** est une application web de covoiturage inter-sites développée en PHP selon une architecture MVC.

Elle permet aux utilisateurs de consulter les trajets proposés entre différentes agences et, après connexion, de créer et de gérer leurs propres trajets.

Un espace d'administration permet également de voir les utilisateurs, de gérer les agences et l'ensemble des trajets.

## Fonctionnalités

### Utilisateurs
- Consulter les trajets proposés.
- Se connecter à l'application.
- Consulter les informations détaillées d'un trajet.
- Créer un trajet.
- Modifier et supprimer ses propres trajets.

### Administrateurs
- Accéder à un tableau de bord d'administration.
- Consulter les utilisateurs et leurs informations.
- Gérer les agences.
- Consulter, modifier et supprimer les trajets.

L'application ne propose pas de création de compte publique. Les comptes utilisateurs sont préalablement enregistrés dans la base de données.

## Environnement technique

### Technologies utilisées
- **PHP 8.5.12** : développement côté serveur.
- **MariaDB** : système de gestion de base de données.
- **HTML5** : structure des pages.
- **SCSS / CSS3** : mise en forme.
- **Bootstrap** : framework CSS.
- **Bootstrap Icons** : bibliothèque d'icônes.
- **JavaScript** : interactions côté client, notamment à travers les composants interactifs de Bootstrap.

### Outils de développement
- **Composer** : gestion des dépendances PHP.
- **Node.js / npm** : gestion des dépendances front-end.
- **PHPUnit** : tests automatisés.
- **PHPStan** : analyse statique du code PHP.
- **Git** : gestion des versions.

Le projet requiert PHP 8.2 ou une version supérieure, avec notamment l'extension PDO MySQL activée.

## Installation

### 1. Récupération du projet

Clonez le dépôt GitHub :

```bash
git clone https://github.com/Lutch-1314/devoir-touche-pas-au-klaxon.git
```

Placez-vous ensuite dans le dossier du projet :

```bash
cd devoir-touche-pas-au-klaxon
```

### 2. Installation des dépendances PHP

À la racine du projet, exécutez :

```bash
composer install
```

### 3. Création et configuration de la base de données

Créez une base de données nommée :

```sql
CREATE DATABASE touche_pas_au_klaxon
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

Importez ensuite les deux scripts SQL fournis dans le dossier `database/`, dans cet ordre :

1. `database/schema.sql` : création des tables et de leurs relations.
2. `database/data.sql` : insertion des données de test (utilisateurs, agences et trajets).

Créez le fichier de configuration local à partir du fichier d'exemple :

```powershell
Copy-Item config\config.example.php config\config.php
```

Modifiez ensuite `config/config.php` afin de renseigner les informations de connexion à votre base de données :

```php
return [
    "host" => "localhost",
    "dbname" => "touche_pas_au_klaxon",
    "username" => "votre_utilisateur",
    "password" => "votre_mot_de_passe",
    "charset" => "utf8mb4",
];
```

Remplacez les identifiants par ceux de votre environnement local.

### 4. Installation des dépendances front-end

Installez les dépendances Node.js :

```bash
npm install
```

Pour compiler les fichiers SCSS en CSS, exécutez :

```bash
npm run sass
```

Cette commande lance la compilation en mode surveillance : les fichiers CSS sont automatiquement actualisés lorsque les fichiers SCSS sont modifiés.

### 5. Lancement de l'application

Démarrez le serveur de base de données MySQL depuis le panneau de contrôle XAMPP.

Depuis la racine du projet, lancez le serveur PHP intégré :

```bash
php -S localhost:8000 -t public
```

L'application est alors accessible depuis le navigateur à l'adresse :

http://localhost:8000/

Pour administrer la base de données avec phpMyAdmin, démarrez également Apache dans XAMPP et accédez à :

http://localhost/phpmyadmin

## Utilisation

La page d'accueil affiche les trajets futurs disposant de places disponibles.

Les utilisateurs peuvent se connecter à l'aide de leurs identifiants afin d'accéder aux informations détaillées des trajets et aux fonctionnalités de gestion de leurs propres trajets.

Les administrateurs disposent d'un espace dédié accessible à l'adresse :

```text
/admin
```

## Architecture du projet

L'application repose sur une architecture MVC qui sépare les responsabilités :

- **Models** : gestion des données et interactions avec la base de données.
- **Views** : affichage des pages et des éléments de l'interface.
- **Controllers** : traitement des requêtes et coordination entre les modèles et les vues.
- **Core** : classes fondamentales de l'application, notamment le routeur, la gestion des sessions et l'accès à la base de données.

Les principaux dossiers du projet sont organisés de la manière suivante :

```text
app/
├── Controllers/
├── Core/
├── Models/
└── Views/

config/
database/
public/
├── assets/
└── index.php

scss/
tests/
```

## Qualité et tests

Le projet utilise deux outils pour vérifier la qualité du code :

### PHPStan

PHPStan réalise une analyse statique du code PHP afin de détecter certaines erreurs potentielles.

L'analyse est configurée au niveau 5.

Pour lancer l'analyse :

```bash
composer analyse
```

### PHPUnit

PHPUnit permet d'exécuter les tests automatisés des modèles `Agency` et `Trip`.

Les tests vérifient notamment :
- La création, la modification et la suppression des données.
- La récupération des agences et des trajets.
- L'appartenance d'un trajet à un utilisateur.
- L'utilisation d'une agence dans les trajets.
- La disponibilité des trajets.

Les tests utilisent une base SQLite en mémoire afin de ne pas modifier les données de la base MariaDB utilisée par l'application.

Pour lancer les tests :

```bash
composer test
```
