<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Service\RandomElementsGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use KnpU\LoremIpsumBundle\KnpUIpsum;
use Nubs\RandomNameGenerator\Vgng as NameGenerator;

class ProductFixtures extends Fixture
{

    private $randomGenerator;

    public function __construct(RandomElementsGenerator $randomGenerator)
    {
        $this->randomGenerator = $randomGenerator;
    }

    public function load(ObjectManager $manager) : void
    {
        for ($i = 0; $i < 12; $i++) {
            $product = new Product;
            $product->setName($this->randomGenerator->getRandomName());
            $product->setDescription($this->randomGenerator->getRandomLoremIpsumParagraph());
            $product->setPrice($this->randomGenerator->getRandomFloat(5,250));
            $manager->persist($product);
        }

        $manager->flush();
    }

}
