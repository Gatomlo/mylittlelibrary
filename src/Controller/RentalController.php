<?php

namespace App\Controller;

use App\Entity\Rental;
use App\Entity\BookRental;
use App\Form\RentalType;
use App\Repository\RentalRepository;
use App\Repository\BookRentalRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('rental/index.html.twig', [
            
        ]);
    }

    /**
     * @Route("/new", name="rental_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,BookRepository $BookRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $rental = new Rental();
        $form = $this->createForm(RentalType::class, $rental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rental->setLocationDate(new \DateTime('NOW'));
            $booksListString = $form["books"]->getData();
            $booksListArray = explode(",",$booksListString);
            foreach ($booksListArray as &$oneBook) {
                $oneBookArray = explode("/",$oneBook);
                $bookId = $oneBookArray[0];
                $actualBook = $BookRepository->findOneBy(array('id'=> $bookId ));
                $bookRental = new BookRental();
                $bookRental->setStatus("borrowed");
                $bookRental->setRental($rental);
                $bookRental->setBook($actualBook);
                $bookRental->setDueDate(new \DateTime('NOW'));
                $entityManager->persist($bookRental);
                $rental->addBookRental($bookRental);
            }

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
     * @Route("/return/{id}", name="return")
     */
    public function return(BookRentalRepository $bookRentalRepository,rentalRepository $rentalRepository,$id, EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $bookRental = $bookRentalRepository->findOneBy(array('id'=> $id ));
        $rentalId= $bookRental->getRental()->getId();
        $actualRental = $rentalRepository->findOneBy(array('id'=> $rentalId ));
        $bookRental -> setReturnDate(new \DateTime('NOW'));
        $bookRental -> setStatus('return');
        $entityManager->persist($bookRental);
        $bookRentals = $actualRental->getBookRentals();
        $actualRental -> setReturnStatus(true);
        $rentalStatusForJson = true;
        foreach ($bookRentals as &$oneBookRental) {
          if (is_null($oneBookRental->getReturnDate())){
            $actualRental -> setReturnStatus(false);
            $rentalStatusForJson = false;
          }
        }
        $entityManager->persist($actualRental);
        $entityManager->flush();
        return new JsonResponse($rentalStatusForJson);
    }

    /**
     * @Route("/{id}", name="rental_show", methods={"GET"})
     */
    public function show(Rental $rental): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('rental/show.html.twig', [
            'rental' => $rental,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rental_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Rental $rental, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$rental->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rental);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rental_index', [], Response::HTTP_SEE_OTHER);
    }
}
