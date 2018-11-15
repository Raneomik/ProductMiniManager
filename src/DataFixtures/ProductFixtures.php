<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use KnpU\LoremIpsumBundle\KnpUIpsum;
use Nubs\RandomNameGenerator\Vgng as NameGenerator;

class ProductFixtures extends Fixture
{

    private $nameGenerator;

    private $descriptionGenerator;

    public function __construct(KnpUIpsum $knpUIpsum)
    {
        $this->descriptionGenerator = $knpUIpsum;
        $this->nameGenerator = new NameGenerator;
    }

    public function load(ObjectManager $manager) {
        $randomFactory = new RandomFactory;

        for ($i = 0; $i < 12; $i++) {
            $product = new Product;
            $product->setName($this->nameGenerator->getName());
            $product->setDescription($this->descriptionGenerator->getParagraphs());
            $product->setPrice($this->randomFloat(5,500));
            $manager->persist($product);
        }

        $manager->flush();
    }

    private function randomFloat($st_num=0,$end_num=1,$mul=100000) : float
    {
        return number_format((float)rand($st_num , $end_num), 2);
    }
}
