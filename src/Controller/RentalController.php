<?php

namespace App\Controller;

use App\Entity\Rental;
use App\Form\RentalType;
use App\Repository\RentalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rental")
 */
class RentalController extends AbstractController
{
    /**
     * @Route("/", name="rental_index", methods={"GET"})
     */
    public function index(RentalRepository $rentalRepository): Response
    {
        return $this->render('rental/index.html.twig', [
            'rentals' => $rentalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="rental_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rental = new Rental();
        $form = $this->createForm(RentalType::class, $rental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rental);
            $entityManager->flush();

            return $this->redirectToRoute('rental_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rental/new.html.twig', [
            'rental' => $rental,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="rental_show", methods={"GET"})
     */
    public function show(Rental $rental): Response
    {
        return $this->render('rental/show.html.twig', [
            'rental' => $rental,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rental_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Rental $rental, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RentalType::class, $rental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('rental_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rental/edit.html.twig', [
            'rental' => $rental,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="rental_delete", methods={"POST"})
     */
    public function delete(Request $request, Rental $rental, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rental->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rental);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rental_index', [], Response::HTTP_SEE_OTHER);
    }
}
