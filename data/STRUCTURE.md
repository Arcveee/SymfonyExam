# Structure des fichiers JSON

## data/produits.json
```json
{
    "1": {
        "id": 1,
        "libelle": "Smartphone",
        "prix": 299500,
        "qteStock": 50,
        "categorie": "Électronique"
    }
}
```

## data/commandes.json
```json
[
    {
        "id": "unique_id",
        "date": "2024-01-15 14:30:00",
        "montant": 339400,
        "achats": [
            {
                "produit": "Smartphone",
                "qte": 1,
                "prix": 299500,
                "total": 299500
            },
            {
                "produit": "Écouteurs Bluetooth",
                "qte": 1,
                "prix": 39900,
                "total": 39900
            }
        ]
    }
]
```

## Prix en FCFA
Tous les prix sont affichés en Francs CFA (FCFA).
