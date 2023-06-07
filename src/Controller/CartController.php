<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{

    #[Route('/mon-panier', name: 'panier_card')]
    public function index(CartService $cartService): Response
    {
        // dd($cartService->getTotal());
        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->getTotal()
        ]);
    }

    #[Route('/mon-panier/{id<\d+>}', name: 'addTo_panier')]
    public function addItem(CartService $cartService, int $id): RedirectResponse
    {
        $cartService->addToCart($id);
        $this->addFlash('success', 'Produit a bien été ajoutée');
        return $this->redirectToRoute("product_home");
    }

    #[Route('/mon-panier/remove/{id<\d+>}', name: 'remove_item')]
    public function removeItem(CartService $cartService, int $id): RedirectResponse
    {
        $cartService->removeFromCart($id);
        return $this->redirectToRoute("panier_card");
    }


    #[Route('/mon-panier/increase/{id<\d+>}', name: 'cart_increase')]
    public function quantiteIncrease(CartService $cartService, int $id): RedirectResponse
    {
        $cartService->addToCart($id);
        return $this->redirectToRoute("panier_card");
    }



    #[Route('/mon-panier/decrease/{id<\d+>}', name: 'cart_decrease')]
    public function quantityDecrease(CartService $cartService, int $id): RedirectResponse
    {
        $cartService->decreaseQuantityFromCart($id);
        return $this->redirectToRoute("panier_card");
    }



    #[Route('/mon-panier/vide', name: 'panier_vide')]
    public function addToRouteSupprimer(CartService $cartService): RedirectResponse
    {
        $cartService->removeCart();
        return $this->redirectToRoute("panier_card");
    }
}
