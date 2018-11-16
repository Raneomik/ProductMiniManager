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


    public function getRandomFloat(int $st_num=0, int $end_num=1, int $divider = 100) : float
    {
        $st_num *= $divider;
        $end_num *= $divider;
        return number_format((float)rand($st_num , $end_num) / $divider, 2);
    }

}