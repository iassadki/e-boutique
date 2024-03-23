<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartLine;
use App\Entity\Product;
use App\Form\CartLineType;
use App\Repository\CartLineRepository;
use App\Repository\ProductRepository;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart/line')]
class CartLineController extends AbstractController
{
    #[Route('/', name: 'app_cart_line_index', methods: ['GET'])]
    public function index(CartLineRepository $cartLineRepository): Response
    {
        return $this->render('cart_line/index.html.twig', [
            'cart_lines' => $cartLineRepository->findAll(),
        ]);
    }

    #[Route('/new/{productId}', name: 'app_cart_line_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CartRepository $cartRepository, ProductRepository $productRepository, $productId, CartLineRepository $cartLineRepository): Response
    {

        $user = $this->getUser();

        if (!$user) {
            // Redirect to login page or show error message
            return $this->redirectToRoute('app_login');
        }

         // Try to find an existing cart for the user
        $cart = $cartRepository->findOneBy(['user' => $user]);

        // If no cart exists, create a new one
        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
            $entityManager->persist($cart);
            $entityManager->flush();
        }

        $product = $productRepository->find($productId);
        if (!$product) {
            throw $this->createNotFoundException('The product does not exist');
        }
       
        $cartLine = new CartLine();
        $cartLine->setCart($cart);
        
        if($cartLineRepository->findOneBy(['product'=> $product])){
           //redirect to product page
              return $this->redirectToRoute('app_product_index');
        }        
        

        $cartLine->setProduct($product);
        $cartLine->setQuantity($cartLine->getQuantity() + 1);
        
        $entityManager->persist($cartLine);
        $entityManager->flush();

        return $this->render('cart_line/new.html.twig', [
            'cart' => $cartLineRepository->findAll(),
            'cart_line' => $cartLine,
            'product_id'=> $productId
        ]);
    }

    #[Route('/{id}', name: 'app_cart_line_show', methods: ['GET'])]
    public function show(CartLine $cartLine): Response
    {
        return $this->render('cart_line/show.html.twig', [
            'cart_line' => $cartLine,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cart_line_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CartLine $cartLine, EntityManagerInterface $entityManager): Response
    {
        //update quantity
        $cartLine->setQuantity($cartLine->getQuantity() + 1);
        $entityManager->persist($cartLine);
        $entityManager->flush();

         return $this->redirectToRoute('app_cart_line_new');
    }

    #[Route('/{id}', name: 'app_cart_line_delete', methods: ['POST'])]
    public function delete(Request $request, CartLine $cartLine, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cartLine->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cartLine);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cart_line_index', [], Response::HTTP_SEE_OTHER);
    }
}
