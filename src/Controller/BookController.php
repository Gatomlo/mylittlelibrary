<?php

namespace App\Controller;
use App\Entity\Book;
use App\Entity\Category;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
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
    public function new(Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
          $entityManager->persist($book);
          $entityManager->flush();
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
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $entityManager->remove($book);
            $entityManager->flush();
        }
        return $this->redirectToRoute('book_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/findBook/{code}", name="find_book")
     */
    public function jsonFindBookAction(BookRepository $bookRepo, $code)
   {
       $book = $bookRepo-> findOneBy(array('code'=> $code));
       $findedBook['id'] = $book->getId();
       $findedBook['code'] = $book->getCode();
       $findedBook['title'] = $book->getTitle();
       $findedBook['author'] = $book->getAuthor();
       return new JsonResponse($findedBook);
   }


}
