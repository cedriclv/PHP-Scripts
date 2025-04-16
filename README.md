# 📡 API REST PHP - Gestion des utilisateurs

Ce projet est une API REST basique en PHP permettant d'effectuer des opérations CRUD (Create, Read, Update, Delete) sur des utilisateurs.

## ⚙️ Fonctionnalités

- 🔍 Récupérer la liste des utilisateurs (GET)
- ➕ Ajouter un utilisateur (POST)
- ✏️ Modifier un utilisateur (PUT)
- ❌ Supprimer un utilisateur (DELETE)
- 📦 Connexion à une base de données MySQL via PDO
- 🔐 Validation simple des inputs

---

## ⚙️ Exemples de POST

{
  "name": "Jean Dupont",
  "email": "jean.dupont@example.com"
}

## ⚙️ Exemples de Reponse

{
  "success": true,
  "message": "Utilisateur ajouté",
  "data": {
    "id": 5,
    "nom": "Jean Dupont",
  }
}
