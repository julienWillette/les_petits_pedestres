<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(SessionInterface $session, ProductRepository $productRepository)
    {
        $cart = $session->get('cart', []);

        $cartWithData = [];

        foreach ($cart as $id => $quantity) {
            $cartWithData[] = [
                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($cartWithData as $couple) {
            $total += $couple['product']->getPrice() * $couple['quantity'];
        }

        return $this->render('cart/index.html.twig', [
            "items" => $cartWithData,
            "total" => $total
        ]);
    }

    /**
     * @Route("/add/{id}", name="cart_add")
     */
    public function add($id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);

        if (empty($cart[$id])) {
            $cart[$id] = 0;
        }

        $cart[$id]++;

        $session->set('cart', $cart);
         
        $session->get('count', []);
        
        $count = 0;
        
        foreach ($cart as $key=>$value) {
            $count = $value + $count;
        } 
 
        $session->set('count', $count);
        
        return $this->redirectToRoute("product");
    }

    /**
     * @Route("/delete/{id}", name="cart_remove")
     */
    public function remove($id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        $count = 0;
        
        foreach ($cart as $key=>$value) {
            $count = $value + $count;
        } 
 
        $session->set('count', $count);

        return $this->redirectToRoute('cart_index');
    }

    /**
    * @Route("/success", name="success")
    */
    public function success(SessionInterface $session)
    {
        $session->clear();
        return $this->render('cart/success.html.twig');
    }

}