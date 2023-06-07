<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private $requestStack;
    private EntityManagerInterface $em;
    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        $this->requestStack = $requestStack;
        $this->em = $em;
    }

    public function addToCart(int $id): void
    {
        $card = $this->requestStack->getSession()->get('cart', []);
        if (!empty($card[$id])) {
            $card[$id]++;
        } else {
            $card[$id] = 1;
        }
        $this->getSession()->set('cart', $card);
    }

    public function decreaseQuantityFromCart(int $id): void
    {
        $card = $this->requestStack->getSession()->get('cart', []);
        if ($card[$id] > 1) {
            $card[$id]--;
        } else {
            $card[$id] = 0;
            // unset($cart[$id]);
        }

        $this->getSession()->set('cart', $card);
    }



    public  function removeCart()
    {
        return $this->getSession()->remove('cart');
    }

    public function getTotal(): array
    {
        $cart = $this->getSession()->get('cart');

        $cartData = [];
        if ($cart) {
            foreach ($cart as $id => $quantity) {
                $product = $this->em->getRepository(Product::class)->findOneBY(['id' => $id]);
                if (!$product) {
                    echo "fsdqf";
                }
                $cartData[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }
        return $cartData;
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }

    public function removeFromCart(int $id)
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        unset($cart[$id]);
        return $this->getSession()->set('cart', $cart);
    }
}
