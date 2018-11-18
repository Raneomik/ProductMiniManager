<?php

namespace App\Twig;

use App\Service\SessionCartManager;
use Symfony\Component\CssSelector\XPath\Translator;
use Symfony\Component\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    /** @var SessionCartManager $sessionCartManager */
    private $sessionCartManager;

    private $localeList;

    /**
     * AppExtension constructor.
     * @param SessionCartManager $sessionCartManager
     * @param $availableLocales
     */
    public function __construct(SessionCartManager $sessionCartManager, $availableLocales)
    {
        $this->sessionCartManager = $sessionCartManager;
        $this->localeList = $availableLocales;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('total_cart_item_number', [$this, 'getCartTotalItemsNumber']),
            new TwigFunction('available_locales', [$this, 'getAvailableLocales']),
        ];
    }

    public function getCartTotalItemsNumber() : int
    {
        $shoppingCart = $this->sessionCartManager->getSessionCart();

        if($shoppingCart){
            return $shoppingCart->getItemTotalCount();
        }

        return 0;
    }

    public function getAvailableLocales() : array
    {
        return $this->localeList;
    }
}
