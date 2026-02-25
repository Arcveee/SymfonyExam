<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommandeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route('/commande/passer', name: 'commande_passer')]
    public function passer(): Response
    {
        $produits = $this->loadProduits();
        return $this->render('commande/passer.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/commande/valider', name: 'commande_valider', methods: ['POST'])]
    public function valider(Request $request): Response
    {
        $quantities = $request->request->all('quantities');
        $produits = $this->loadProduits();
        
        $achats = [];
        $montant = 0;

        foreach ($quantities as $produitId => $qte) {
            if ($qte > 0) {
                $produit = $produits[$produitId] ?? null;
                if ($produit && $produit['qteStock'] >= $qte) {
                    $achats[] = [
                        'produit' => $produit['libelle'],
                        'qte' => $qte,
                        'prix' => $produit['prix'],
                        'total' => $produit['prix'] * $qte
                    ];
                    $montant += $produit['prix'] * $qte;
                    $produits[$produitId]['qteStock'] -= $qte;
                }
            }
        }

        if (empty($achats)) {
            $this->addFlash('error', 'La commande doit contenir au moins un produit.');
            return $this->redirectToRoute('commande_passer');
        }

        $commande = [
            'id' => uniqid(),
            'date' => date('Y-m-d H:i:s'),
            'montant' => $montant,
            'achats' => $achats
        ];

        $this->saveCommande($commande);
        $this->saveProduits($produits);

        $this->addFlash('success', 'Commande passée avec succès!');
        return $this->redirectToRoute('commande_list');
    }

    #[Route('/commande/list', name: 'commande_list')]
    public function list(): Response
    {
        $commandes = $this->loadCommandes();
        return $this->render('commande/list.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    private function loadProduits(): array
    {
        $file = $this->getParameter('kernel.project_dir') . '/data/produits.json';
        if (!file_exists($file)) {
            $this->initData();
        }
        return json_decode(file_get_contents($file), true);
    }

    private function saveProduits(array $produits): void
    {
        $file = $this->getParameter('kernel.project_dir') . '/data/produits.json';
        file_put_contents($file, json_encode($produits, JSON_PRETTY_PRINT));
    }

    private function loadCommandes(): array
    {
        $file = $this->getParameter('kernel.project_dir') . '/data/commandes.json';
        if (!file_exists($file)) return [];
        return json_decode(file_get_contents($file), true) ?? [];
    }

    private function saveCommande(array $commande): void
    {
        $commandes = $this->loadCommandes();
        $commandes[] = $commande;
        $file = $this->getParameter('kernel.project_dir') . '/data/commandes.json';
        file_put_contents($file, json_encode($commandes, JSON_PRETTY_PRINT));
    }

    private function initData(): void
    {
        $dir = $this->getParameter('kernel.project_dir') . '/data';
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $produits = [
            1 => ['id' => 1, 'libelle' => 'Smartphone', 'prix' => 45000, 'qteStock' => 50, 'categorie' => 'Électronique'],
            2 => ['id' => 2, 'libelle' => 'Écouteurs Bluetooth', 'prix' => 8500, 'qteStock' => 100, 'categorie' => 'Électronique'],
            3 => ['id' => 3, 'libelle' => 'Laptop', 'prix' => 125000, 'qteStock' => 30, 'categorie' => 'Informatique'],
            4 => ['id' => 4, 'libelle' => 'Souris sans fil', 'prix' => 3500, 'qteStock' => 150, 'categorie' => 'Informatique'],
            5 => ['id' => 5, 'libelle' => 'Clavier mécanique', 'prix' => 12000, 'qteStock' => 75, 'categorie' => 'Informatique'],
            6 => ['id' => 6, 'libelle' => 'PHP pour les nuls', 'prix' => 5500, 'qteStock' => 200, 'categorie' => 'Livres'],
        ];

        $this->saveProduits($produits);
        file_put_contents($dir . '/commandes.json', '[]');
    }
}
