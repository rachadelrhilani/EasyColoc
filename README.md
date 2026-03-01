# EasyColoc- Système de Gestion de Colocation

Une solution complète développée avec **Laravel** pour simplifier la gestion des dépenses, la répartition des frais et la modération des membres au sein d'une colocation.

---

## Fonctionnalités Clés

### Gestion des Utilisateurs & Rôles
Le système repose sur trois types de profils avec des permissions distinctes :

* **Admin** : 
    * Vue panoramique sur les statistiques globales.
    * Pouvoir de **Bannir/Débannir** tout utilisateur.
    * Gestion de l'intégrité de la plateforme.
* **Owner (Propriétaire)** :
    * Gestion complète de sa colocation (Nom, Description).
    * Administration des membres (Invitations, Suppression).
    * Configuration des catégories de dépenses.
* **Membre** :
    * Suivi des soldes et des dettes en temps réel.
    * Consultation du flux de dépenses collectives.

### Sécurité & Logique de Succession
Une logique métier avancée a été implémentée pour garantir la continuité du service :
* **Protection Admin** : Le rôle d'Administrateur est protégé et ne peut être modifié lors d'un bannissement.
* **Transfert de Propriété** : Si un *Owner* est banni, le système identifie automatiquement le membre le plus ancien (via `date_adhesion`) pour lui transmettre le rôle de responsable.
* **Accès Sécurisé** : Les utilisateurs sans colocation sont redirigés vers un espace d'attente (Onboarding) limitant l'accès aux fonctions financières.

### Gestion des Finances & Colocations
* **Dashboard Dynamique** : Interface adaptée selon le statut de l'utilisateur (Seul, Membre ou Owner).
* **Personnalisation** : Modification du nom et de la description de l'espace commun.
* **Organisation** : Système CRUD complet pour les catégories de dépenses (Ajouter, Modifier, Supprimer).

---

## Stack Technique

* **Framework** : [Laravel 11](https://laravel.com)
* **Frontend** : [Tailwind CSS](https://tailwindcss.com) & Blade Templates
* **Base de données** : MySQL
* **Gestion d'état** : Middleware personnalisé pour la vérification `est_actif`.

---

## Installation & Configuration

1. **Clonage du dépôt**
   ```bash
   git clone https://github.com/rachadelrhilani/EasyColoc
   cd coloc-manage
  ```
2. **Installation des dépendances**
   ```bash
  composer install
  ```
3. **Configuration de l'environnement**
```bash
  cp .env.example .env
php artisan key:generate
```
4. **Lancement**
```bash
 php artisan serve
```