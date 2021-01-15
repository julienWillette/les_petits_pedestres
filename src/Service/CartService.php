<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

    private $session;

    public function __construct(SessionInterface $session) 
    {
        $this->session = $session;
    }

    public function add($id)
    {
        $cart = $this->session->get('cart', []);

        if (empty($cart[$id])) {
            $cart[$id] = 0;
        }

        $cart[$id]++;

        $this->session->set('cart', $cart);
         
        $this->session->get('count', []);
        
        $count = 0;
        
        foreach ($cart as $key=>$value) {
            $count = $value + $count;
        } 
 
        $this->session->set('count', $count);
    }
}