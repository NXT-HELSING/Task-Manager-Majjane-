# 🚀 Application de Gestion de Projets & Tâches – Laravel

Une application web complète développée avec **Laravel** pour la gestion des projets, des tâches et de la collaboration entre les membres d'équipe.  
Chaque utilisateur peut créer, modifier et suivre ses projets, assigner des membres, et gérer le statut des tâches dans une interface intuitive et moderne.

---

## ✨ Fonctionnalités Principales

- 🔐 **Authentification** - Système sécurisé d'inscription et de connexion
- 📊 **Tableau de Bord Dynamique** - Vue d'ensemble de vos projets et tâches
- 👥 **Collaboration d'Équipe** - Attribution des membres aux projets
- 🗂️ **Gestion des Projets** - Création, édition et organisation des projets
- ✅ **Gestion des Tâches** - Suivi des tâches avec statuts dynamiques
- 🎯 **Statuts Dynamiques** - `active`, `on_hold`, `completed`
- 📱 **Design Responsive** - Interface moderne adaptée à tous les appareils
- 🔒 **Protection des Routes** - Gestion sécurisée des accès et rôles
- 💫 **Formulaires et Modals Stylisés** - Interface utilisateur moderne et intuitive

---

## 🛠️ Technologies Utilisées

| Catégorie       | Technologie       |
| --------------- | ----------------- |
| Backend         | Laravel 12.x      |
| Base de données | MySQL             |
| Frontend        | Blade, Bootstrap  |
| Langage         | PHP 8.2           |
| Outils          | Composer, Artisan |

---

## ⚡ Installation & Configuration

### 1️⃣ Cloner le dépôt
```bash
git clone https://github.com/NXT-HELSING/Task-Manager-Majjane-.git
cd Task-Manager-Majjane-
```

### 2️⃣ Installer les dépendances PHP
```bash
composer install
```

### 3️⃣ Configurer l'environnement
```bash
cp .env.example .env
php artisan key:generate
```

### 4️⃣ Configurer la base de données
Ouvrez le fichier `.env` et modifiez les paramètres de la base de données :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project_manager
DB_USERNAME=root
DB_PASSWORD=
```

### 5️⃣ Exécuter les migrations
```bash
php artisan migrate --seed
```

### 6️⃣ Démarrer le serveur
```bash
php artisan serve
```

### 7️⃣ Accéder à l'application
Ouvrez votre navigateur et accédez à : `http://127.0.0.1:8000`

---

## 🎨 Interface Utilisateur

- **Interface Moderne** - Design professionnel et épuré avec Bootstrap 5
- **Layout Responsive** - Optimisé pour desktop, tablette et mobile
- **Éléments Interactifs** - Formulaires dynamiques et modales stylisées
- **Navigation Intuitive** - Gestion facile des projets et tâches
- **Feedback Visuel** - Indicateurs de statut et progression clairs

---

## 👨‍💻 Auteur

**Abderrahim Ajabli**  
Développeur Web Full Stack passionné par la création d'applications efficaces et conviviales.

💻 Laravel
 | 🎨 Blade | 🗂️ MySQL

---

<div align="center">

### ⭐ N'hésitez pas à donner une étoile à ce repo si vous le trouvez utile !

</div>
