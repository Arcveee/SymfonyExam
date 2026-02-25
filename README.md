# Application de Gestion de Commandes

## Description
Application web Symfony pour passer des commandes de produits.

## Structure
- **Produits** : libelle, prix (FCFA), qteStock, catégorie
- **Commandes** : date, montant, achats

## Installation

### Lancer le serveur
```bash
start-server.bat
```
OU
```bash
php -S localhost:8000 -t public
```

## Utilisation

### Accéder à l'application
- Page d'accueil: http://localhost:8000
- Passer une commande: http://localhost:8000/commande/passer
- Liste des commandes: http://localhost:8000/commande/list

### Fonctionnalités
1. **Passer une commande** : Sélectionner les produits et quantités, valider
2. **Lister les commandes** : Voir toutes les commandes avec détails

## Base de données
- **Fichiers JSON** dans le dossier `data/`
  - `produits.json` : Liste des produits avec stock
  - `commandes.json` : Historique des commandes
- Pas besoin de serveur de base de données
- Les données sont initialisées automatiquement au premier lancement

## Règles de gestion
- Une commande doit contenir au moins un achat
- Le stock est automatiquement décrémenté lors d'une commande
- Le montant est calculé automatiquement
- Prix affichés en FCFA
