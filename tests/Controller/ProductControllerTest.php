<?php

namespace App\Tests\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\RandomElementsGenerator;
use Symfony\Component\Translation\Translator;


class ProductControllerTest extends WebTestCase
{

    public function setUp() : void
    {
        parent::setUp();
        self::bootKernel();
    }

    /**
     * @test
     */
    public function testControllerResponse() : void
    {
        $translator = self::$container->get('translator');

        $client  = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains($translator->trans('product.list'), $crawler->filter('h1')->text());
    }

    /**
     * @test
     */
    public function testHomeTranslations() : void
    {
        $translator = self::$container->get('translator');

        $client         = static::createClient();
        $englishCrawler = $client->request('GET', '/');
        $frenchCrawler  = $client->request('GET', '/fr/');

        $this->assertContains($translator->trans('product.list', [], null, 'en'), $englishCrawler->filter('h1')->text());
        $this->assertContains($translator->trans('product.list', [], null, 'fr'), $frenchCrawler->filter('h1')->text());
    }

    /**
     * @test
     */
    public function testProductCount() : void
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertEquals($crawler->filter('[id^="product-"]')->count(), 12);
        $this->assertEquals($crawler->filter('.product')->count(), 12);
    }
}
