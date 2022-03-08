<?php

namespace App\Controller;
use App\Entity\Book;
use App\Entity\Sample;
use App\Entity\Category;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Repository\SampleRepository;
use App\Repository\BookRentalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/book")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="book_index", methods={"GET"})
     */
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="book_new", methods={"GET", "POST"})
     */
    public function new(Request $request,BookRepository $BookRepository, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        $isbn = $form["ISBN"]->getData();
        $existingBook = $BookRepository-> findOneBy(array('ISBN'=> $isbn));
        if(empty($existingBook)){
          $categories = $form["category"]->getData();
          $categoriesArray = explode(",",$categories);
          foreach ($categoriesArray as &$category) {
            $existingCategory = $categoryRepository-> findOneBy(array('name'=> $category));
            if (empty($existingCategory)){
               $newCategory = new Category();
               $newCategory->setName($category);
               $entityManager->persist($newCategory);
               $book->addCategory($newCategory);
             }
             else{
               $book->addCategory($existingCategory);
             }
           }
          $numberOfSamples = $form["numberOfSample"]->getData();
          for ($i = 1; $i <= $numberOfSamples; $i++) {
            $sample = new Sample();
            $sample->setCode(uniqid());
            $entityManager->persist($sample);
            $book->addSample($sample);
            $entityManager->flush();
          }
          $entityManager->persist($book);
          $entityManager->flush();
        }
        else{
          $numberOfSamples = $form["numberOfSample"]->getData();
          for ($i = 1; $i <= $numberOfSamples; $i++) {
            $sample = new Sample();
            $sample->setCode(uniqid());
            $entityManager->persist($sample);
            $existingBook->addSample($sample);
            $entityManager->flush();
          }
          $entityManager->persist($existingBook);
          $entityManager->flush();
        }

          return $this->redirectToRoute('book_index', [], Response::HTTP_SEE_OTHER);
      }
        return $this->renderForm('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="book_show", methods={"GET"})
     */
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="book_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Book $book, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $existingCategoriesFromBook = $book->getCategory();
        $existingCategoryArray = [];
        foreach ($existingCategoriesFromBook as $category) {
          $currentCategory = $category->getName();
          array_push($existingCategoryArray, $currentCategory);
        };
        $existingCategoryStringFormat = implode(', ',$existingCategoryArray);
        $form = $this->createForm(BookType::class, $book,array(
        'actualCategory'=>$existingCategoryStringFormat));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($existingCategoriesFromBook as &$category) {
              $book->removeCategory($category);
            }
            $categories = $form["category"]->getData();
            $categoriesArray = explode(",",$categories);
            foreach ($categoriesArray as &$category) {
              $existingCategory = $categoryRepository-> findOneBy(array('name'=> $category));
              if (empty($existingCategory)){
                 $newCategory = new Category();
                 $newCategory->setName($category);
                 $entityManager->persist($newCategory);
                 $book->addCategory($newCategory);
               }
               else{
                 $book->addCategory($existingCategory);
               }
             }
            $entityManager->flush();
            return $this->redirectToRoute('book_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="book_delete", methods={"POST"})
     */
    public function delete(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
      $this->denyAccessUnlessGranted('ROLE_ADMIN');
      if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
          $entityManager->remove($book);
          $entityManager->flush();
      }
        return $this->redirectToRoute('book_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/findBook/{code}", name="find_book")
     */
    public function jsonFindBookAction(SampleRepository $sampleRepository,BookRepository $bookRepository, $code)
   {
       $sample = $sampleRepository-> findOneBy(array('code'=> $code));
       $book = $sample->getBook();
       $findedBook['id'] = $book->getId();
       $findedBook['code'] = $sample->getCode();
       $findedBook['title'] = $book->getTitle();
       $findedBook['author'] = $book->getAuthor();
       return new JsonResponse($findedBook);
   }

   /**
    * @Route("/removeSample/{id}", name="remove_sample")
    */
   public function removeSample(Request $request,SampleRepository $sampleRepository, EntityManagerInterface $entityManager, $id): Response
   {
       $this->denyAccessUnlessGranted('ROLE_ADMIN');
       $actualSample = $sampleRepository->findOneBy(array('id'=> $id));
       $entityManager->remove($actualSample);
       $entityManager->flush();
       return new JsonResponse('success');
   }
}
