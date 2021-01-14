<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    /**
     * @Route("/", name="")
     */
    class BlogController extends AbstractController
    {
        /**
         * @Route("/blog", name="blog")
         */
        public function index(BlogRepository $blogRepository): Response
        { 
            $blogs = $blogRepository->findAll();
            return $this->render('blog/index.html.twig', [
                'blogs' => $blogs,
            ]);
        }
        /**
         * @Route("/blog/{slug}", name="blog_show")
         */
        public function show(Blog $blog): Response
        {
            return $this->render('blog/show.html.twig', [
                'blog' => $blog,
            ]);
        }
    
    }
