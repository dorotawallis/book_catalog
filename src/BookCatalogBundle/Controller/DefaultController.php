<?php

namespace BookCatalogBundle\Controller;

use BookCatalogBundle\Entity\Book;
use BookCatalogBundle\Form\BookType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="bookList")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Book::class);
        $books = $repository->findAll();

        return $this->render('/default/list.html.twig', [
            'books' => $books
        ]);
    }
    
    /**
     * @Route("/add", name="addNew")
     */
	public function newAction(Request $request)
    {
        $book = new Book();

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            $this->addFlash(
                'notice',
                'Twoje zmiany zostały zapisane!'
            );
    
            return $this->redirectToRoute('bookList');
        }
    
        return $this->render('default/bookForm.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/book/{id}", name="showBook", requirements={"id": "\d+"})
     */
    public function showAction($id)
    {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);
    
        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        return $this->render('default/show.html.twig', array(
            'book' => $book,
        ));
    }

    /**
     * @Route("/edit/{id}", name="updateBook", requirements={"id": "\d+"})
     */
    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository(Book::class)->find($id);
    
        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $form = $this->createForm(BookType::class, $book);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $em->persist($book);
            $em->flush();

            $this->addFlash(
                'notice',
                'Twoje zmiany zostały zapisane!'
            );
    
            return $this->redirectToRoute('bookList');
        }
        
        return $this->render('default/bookForm.html.twig', array(
            'form' => $form->createView(),
        ));
        
    }
}
