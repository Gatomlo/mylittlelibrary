<?php

namespace App\Controller;

use App\Entity\Borrower;
use App\Form\BorrowerType;
use App\Repository\BorrowerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/borrower")
 */
class BorrowerController extends AbstractController
{
    /**
     * @Route("/", name="borrower_index", methods={"GET"})
     */
    public function index(BorrowerRepository $borrowerRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('borrower/index.html.twig', [
            'borrowers' => $borrowerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="borrower_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $borrower = new Borrower();
        $form = $this->createForm(BorrowerType::class, $borrower);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($borrower);
            $entityManager->flush();

            return $this->redirectToRoute('borrower_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('borrower/new.html.twig', [
            'borrower' => $borrower,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="borrower_show", methods={"GET"})
     */
    public function show(Borrower $borrower): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('borrower/show.html.twig', [
            'borrower' => $borrower,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="borrower_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Borrower $borrower, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(BorrowerType::class, $borrower);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('borrower_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('borrower/edit.html.twig', [
            'borrower' => $borrower,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="borrower_delete", methods={"POST"})
     */
    public function delete(Request $request, Borrower $borrower, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$borrower->getId(), $request->request->get('_token'))) {
            $entityManager->remove($borrower);
            $entityManager->flush();
        }

        return $this->redirectToRoute('borrower_index', [], Response::HTTP_SEE_OTHER);
    }
}
