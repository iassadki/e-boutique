<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\CartLineRepository;
use App\Repository\CartRepository;
use App\Repository\CustomerAddressRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/order')]
class OrderController extends AbstractController
{
    #[Route('/', name: 'app_order_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_order_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, OrderRepository $orderRepository, CartRepository $cartRepository, CartLineRepository $cartLineRepository): Response
    {
        $order = new Order();
        $user = $this->getUser();
        $order->setId($user);
        $order->setDateTime(new \DateTime());
        $order->setValid(true);
        $random = random_int(100000, 999999);
        while ($orderRepository->findOneBy(['orderNumber' => $random])) {
            // If an order with this number already exists, generate a new random number
            $random = random_int(100000, 999999);
        }
        $order->setOrderNumber($random);
        $cart = $cartRepository->findOneBy(['user' => $user]);
        $order->setCart($cart);
        
        $entityManager->persist($order);
        $entityManager->flush();

        // Remove all CartLines of the user
        $cartLines = $cartLineRepository->findBy(['cart' => $cart]);
        foreach ($cartLines as $cartLine) {
            $entityManager->remove($cartLine);
        }

        // Flush the entity manager to commit the CartLine removals
        $entityManager->flush();



        return $this->redirectToRoute('app_order_show', ['id' => $order->getId()]);
       
    }

    #[Route('/{id}', name: 'app_order_show', methods: ['GET'])]
    public function show(Order $order,EntityManagerInterface $entityManager ,CustomerAddressRepository $customerAddressRepository): Response
    {
        $user = $this->getUser();  
        $customerAddresses = $customerAddressRepository->findBy(['user' => $user]);
        
        foreach($customerAddresses as $customerAddress){
            $entityManager->remove($customerAddress);
        }
        $entityManager->flush();
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_order_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('order/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_order_delete', methods: ['POST'])]
    public function delete(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
    }
}
