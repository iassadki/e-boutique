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

#[Route('/cart_line')]
class CartLineController extends AbstractController
{
    #[Route('/', name: 'app_cart_line_index', methods: ['GET'])]
    public function index(CartLineRepository $cartLineRepository, CartRepository $cartRepository): Response
    { 
        $user = $this->getUser();
        $cart = $cartRepository->findOneBy(['user' => $user]);
    
        $cartLines = [];
        $total = 0;
        if ($cart) {
            $cartLines = $cartLineRepository->findBy(['cart' => $cart]);
            foreach ($cartLines as $cartLine) {
                $total += $cartLine->getProduct()->getPrice() * $cartLine->getQuantity();
            }
        }
    
        return $this->render('cart_line/index.html.twig', [
            'cart_lines' => $cartLines,
            'total' => $total,
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

        //check if product already in cart of the user
        
       if($cartLineRepository->findOneBy(['cart'=> $cart, 'product'=> $product])){
            //redirect to product page
            return $this->redirectToRoute('app_cart_line_index');
       }
        
        $cartLine->setProduct($product);
        $cartLine->setQuantity($cartLine->getQuantity() + 1);
        
        $entityManager->persist($cartLine);
        $entityManager->flush();

        return $this->redirectToRoute('app_cart_line_index');
    }

    #[Route('/{id}', name: 'app_cart_line_show', methods: ['GET'])]
    public function show(CartLine $cartLine): Response
    {
        return $this->render('cart_line/show.html.twig', [
            'cart_line' => $cartLine,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_cart_line_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CartLine $cartLine, EntityManagerInterface $entityManager): Response
    {
        $quantity = $request->request->get('quantity');

        if ($quantity) {
            $cartLine->setQuantity($quantity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cart_line_index');
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
