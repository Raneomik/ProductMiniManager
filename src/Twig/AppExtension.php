<?php

namespace App\Twig;

use App\Service\SessionCartManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    /** @var SessionCartManager $sessionCartManager */
    private $sessionCartManager;

    /**
     * AppExtension constructor.
     * @param SessionCartManager $sessionCartManager
     */
    public function __construct(SessionCartManager $sessionCartManager)
    {
        $this->sessionCartManager = $sessionCartManager;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('total_cart_item_number', [$this, 'getCartTotalItemsNumber']),
        ];
    }

    public function getCartTotalItemsNumber()
    {
        return $this->sessionCartManager->getSessionCart()->getItemTotalCount();
    }
}
