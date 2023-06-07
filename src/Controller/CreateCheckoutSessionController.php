<?php

namespace App\Controller;

use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreateCheckoutSessionController extends AbstractController
{
    /**
     * @throws ApiErrorException
     */
    #[Route('/create-checkout-session', name: 'app_create_checkout_session', methods: ["POST"])]
    public function index(Request $request): RedirectResponse
    {

        $stripeKey = $this->getParameter('STRIPE_SECRET_KEY');
        $stripe = new StripeClient($stripeKey);

        //!!!this used for testing only!!!
        $total_price = $request->get("total_price");
        print_r($total_price);
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Your Total cart',
                    ],
                    'unit_amount' => $total_price * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://localhost:8000/mon-panier/vide',
            'cancel_url' => 'http://localhost:8000/mon-panier',
        ]);

        header("HTTP/1.1 303 See Other");
        header("Location: " . $checkout_session->url);
        //redirection of the user
        return $this->redirect($checkout_session->url, 303);


    }
}
