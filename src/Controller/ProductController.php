<?php

namespace App\Controller;

use App\Entity\Product;
use App\Data\SearchData;
use App\Form\SearchType;
use App\Service\CartService;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    /**
     * @Route("/produit", name="")
     */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product")
     */
    public function index(ProductRepository $productRepository, Request $request): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        $products = $productRepository->findSearch($data);
        [$min, $max] = $productRepository->findMinMax($data);
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'min' => $min,
            'max' => $max
        ]);
    }
    /**
     * @Route("/{slug}", name="product_show")
     */
    public function show(Product $product, CartService $cartService): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ((isset($_POST['submit'])) &&
            (!empty($_POST['add_id']))) {
            }
            $id = $_POST['add_id'];
            $cartService->add($id);
        }
        
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

}
