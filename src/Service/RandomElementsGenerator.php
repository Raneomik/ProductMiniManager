<?php

namespace App\Service;

use KnpU\LoremIpsumBundle\KnpUIpsum;
use Nubs\RandomNameGenerator\Vgng as NameGenerator;


class RandomElementsGenerator
{

    private $nameGenerator;

    private $paragraphGenerator;


    /**
     * RandomElementsGenerator constructor.
     * @param KnpUIpsum $knpUIpsum
     */
    public function __construct(KnpUIpsum $knpUIpsum)
    {
        $this->paragraphGenerator = $knpUIpsum;
        $this->nameGenerator      = new NameGenerator;
    }

    public function getRandomName() : string
    {
        return $this->nameGenerator->getName();
    }

    public function getRandomLoremIpsumParagraph() : string
    {
        return $this->paragraphGenerator->getSentences();
    }


    public function getRandomFloat($st_num=0,$end_num=1) : float
    {
        return number_format((float)rand($st_num , $end_num), 2);
    }

}