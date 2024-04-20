<?php

namespace App\Controller;

use App\Repository\CartLineRepository;
use App\Repository\CartRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(Request $request, CartLineRepository $cartLineRepository, CartRepository $cartRepository, EntityManagerInterface $entityManager): Response
    {

        if ($request->query->get('clear_cart')) {
            // Remove all CartLines of the user
            $cart = $cartRepository->findOneBy(['user' => $this->getUser()]);
            $cartLines = $cartLineRepository->findBy(['cart' => $cart]);
            foreach ($cartLines as $cartLine) {
                $entityManager->remove($cartLine);
            }
            // Flush the entity manager to commit the CartLine removals
            $entityManager->flush();
        }

        return $this->render('home/index.html.twig');
    }


}