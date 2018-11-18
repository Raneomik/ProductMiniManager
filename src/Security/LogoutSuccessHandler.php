<?php

namespace App\Security;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{
    /** @var SessionInterface $session */
    private $session;

    /** @var TranslatorInterface $translator */
    private $translator;

    /** @var RouterInterface $router */
    private $router;

    public function __construct(SessionInterface $session, RouterInterface $router, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
        $this->router = $router;
    }

    public function onLogoutSuccess(Request $request) : Response
    {
        $this->session->getFlashBag()->add(
            'success',
            $this->translator->trans('user.logout.success')
        );

        $route = $this->router->generate('product_list');
        return new RedirectResponse($route);
    }


}