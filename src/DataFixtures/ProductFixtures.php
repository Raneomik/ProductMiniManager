<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nubs\RandomNameGenerator\Vgng as NameGenerator;
use RandomLib\Factory as RandomFactory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager) {
        $randomFactory = new RandomFactory;
        $generator = new NameGenerator;
        $gen = $randomFactory->getMediumStrengthGenerator();

        for ($i = 0; $i < 12; $i++) {
            $product = new Product;
            $product->setName($generator->getName());
            $product->setPrice($gen->generateInt(1, 1000));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
