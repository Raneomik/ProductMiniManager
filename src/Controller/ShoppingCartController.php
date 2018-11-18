<?php

namespace App\Controller;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Form\AddToCartType;
use App\Service\SessionCartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\CssSelector\XPath\Translator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class ShoppingCartController
 * @package App\Controller
 * @Route({
 *     "en": "/shopping-cart",
 *     "fr": "/panier"
 * })
 */
class ShoppingCartController extends AbstractController
{
    /**
     * @Route("/", name="shopping_cart")
     * @param SessionCartManager $cartManager
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function index(SessionCartManager $cartManager, TranslatorInterface $translator) : Response
    {
        $shoppingCart = $cartManager->getSessionCart();
        $products     = $shoppingCart->getCartItems();

        if ($shoppingCart->getItemTotalCount() == 0) {
            $this->addFlash(
                'info',
                $translator->trans('cart.empty')
            );
        }

        return $this->render(
            'shopping_cart/index.html.twig',
            [
                'product_items' => $products,
                'total_price'   => $cartManager->getCartTotalPrice(),
            ]
        );
    }

    /**
     * @Route("/add-product", name="shopping_cart_add")
     * @param SessionCartManager $cartManager
     * @param TranslatorInterface $translator
     * @param Request $request
     * @return Response
     */
    public function addProduct(
        SessionCartManager $cartManager,
        TranslatorInterface $translator,
        Request $request
    ) : Response
    {
        $form = $this->createForm(AddToCartType::class, new CartItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cartItem = $form->getData();
            $cartManager->updateItemInCart($cartItem);

            if ($cartManager->getSessionCart()->getItemTotalCount() > 0) {

                $this->addFlash(
                    'success',
                    $translator->trans('cart.success.add')
                );

                return $this->redirectToRoute('shopping_cart');
            }
        }

        $errors = $form->getErrors();

        foreach($errors as $error){
            $this->addFlash(
                'danger',
                $error->getMessage()
            );
        }

        return $this->redirectToRoute('product_list');
    }

    /**
     * @Route("/remove-product/{id}", name="shopping_cart_remove")
     * @param SessionCartManager $cartManager
     * @param TranslatorInterface $translator
     * @param Product $product
     * @return Response
     */
    public function removeProduct(
        SessionCartManager $cartManager,
        TranslatorInterface $translator,
        Product $product
    ) : Response
    {
        $cartManager->removeFromCart($product);

        if ($cartManager->getSessionCart()->getItemTotalCount() > 0) {
            $this->addFlash(
                'info',
                $translator->trans('cart.success.remove')
            );
        }

        return $this->redirectToRoute('shopping_cart');

    }

    /**
     * @Route("/clean-cart", name="shopping_cart_clean")
     * @param SessionCartManager $cartManager
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function clean(SessionCartManager $cartManager, TranslatorInterface $translator) : Response
    {
        $cartManager->cleanUpCart();

        $this->addFlash(
            'info',
            $translator->trans('cart.success.cleanup')
        );

        return $this->redirectToRoute('product_list');
    }
}
