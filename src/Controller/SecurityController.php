<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="admin_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, TranslatorInterface $translator): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        if($error) {
            $this->addFlash(
                'danger',
                $translator->trans(
                    $error->getMessageKey(),
                    $error->getMessageData(),
                    'security'
                )
            );
        }
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername]);
    }

    /**
     * @Route("/logout", name="admin_logut")
     */
    public function logout() : Response
    {
        $this->redirectToRoute('product_list');
    }

}
