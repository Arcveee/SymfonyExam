<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Créer les catégories
        $cat1 = new Categorie();
        $cat1->setCode('ELEC')->setLibelle('Électronique');
        $manager->persist($cat1);

        $cat2 = new Categorie();
        $cat2->setCode('INFO')->setLibelle('Informatique');
        $manager->persist($cat2);

        $cat3 = new Categorie();
        $cat3->setCode('LIVRE')->setLibelle('Livres');
        $manager->persist($cat3);

        // Créer les produits
        $p1 = new Produit();
        $p1->setLibelle('Smartphone')->setPrix(599.99)->setQteStock(50)->setCategorie($cat1);
        $manager->persist($p1);

        $p2 = new Produit();
        $p2->setLibelle('Écouteurs Bluetooth')->setPrix(79.99)->setQteStock(100)->setCategorie($cat1);
        $manager->persist($p2);

        $p3 = new Produit();
        $p3->setLibelle('Laptop')->setPrix(1299.99)->setQteStock(30)->setCategorie($cat2);
        $manager->persist($p3);

        $p4 = new Produit();
        $p4->setLibelle('Souris sans fil')->setPrix(29.99)->setQteStock(150)->setCategorie($cat2);
        $manager->persist($p4);

        $p5 = new Produit();
        $p5->setLibelle('Clavier mécanique')->setPrix(89.99)->setQteStock(75)->setCategorie($cat2);
        $manager->persist($p5);

        $p6 = new Produit();
        $p6->setLibelle('PHP pour les nuls')->setPrix(24.99)->setQteStock(200)->setCategorie($cat3);
        $manager->persist($p6);

        $manager->flush();
    }
}
