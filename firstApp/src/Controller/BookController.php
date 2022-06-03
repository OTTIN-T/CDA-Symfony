<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/book", name="book:")
 */
class BookController extends AbstractController
{

    // INDEX 
    // --
    // path: /books
    // name: book:index
    /**
     * @Route("s", name="index", methods={"HEAD", "GET"})
     */
    public function index(BookRepository $bookRepository): Response
    {

        // Récupération des données
        // $criteria = [
        //     'title' => "super titre"
        // ];
        // $books = $bookRepository->findBy($criteria);

        $books = $bookRepository->findAll();
        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    // CREATE 
    // --
    // path: /book
    // name: book:create
    /**
     * @Route("", name="create", methods={"HEAD", "GET", "POST"})
     */
    public function create(ManagerRegistry $doctrine, Request $request, ValidatorInterface $validator): Response
    {
        // Récupération de l'entité Book
        $book = new Book;

        // Construction du form
        $form = $this->createForm(BookType::class, $book);

        // Association de la requete courante au form
        $form->handleRequest($request);

        // Test la soumission du form
        if ($form->isSubmitted()) {

            // Affiche   l'erreur de contrainte
            $validator->validate($book);
            if ($form->isValid()) {
                // Enregistre en BDD
                $em = $doctrine->getManager();
                $em->persist($book);
                $em->flush();

                // Message flash
                $this->addFlash('success', "Le livre " . $book->getTitle() . " à été ajouter.");

                return $this->redirectToRoute("book:show", [
                    'id' => $book->getId(),
                ]);
            }
        }
        // Préparation de l'objet $form pour la vue twig
        $form = $form->createView();

        return $this->render('book/create.html.twig', ['form' => $form]);
    }

    // READ 
    // --
    // path: /book/{id}/show
    // name: book:show
    /**
     * @Route("/{id}", name="show", methods={"HEAD", "GET"})
     */
    // Faisable avec $id, BookRepository $bookRepository
    public function show(Book $book): Response
    {
        // $book = $bookRepository->findOneBy($id);
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    // UPDATE 
    // --
    // path: /book/{id}/update
    // name: book:update
    /**
     * @Route("/{id}/edit", name="edit", methods={"HEAD", "GET", "POST"})
     */
    public function update(Book $book, ManagerRegistry $doctrine, Request $request, ValidatorInterface $validator): Response
    {
        // Construction du form
        $form = $this->createForm(BookType::class, $book);

        // Association de la requete courante au form
        $form->handleRequest($request);

        // Test la soumission du form
        if ($form->isSubmitted()) {

            // Affiche   l'erreur de contrainte
            $validator->validate($book);
            if ($form->isValid()) {

                // Enregistre en BDD
                $em = $doctrine->getManager();
                $em->persist($book);
                $em->flush();

                // Message flash
                $this->addFlash('success', "Le livre " . $book->getTitle() . " à été modifié.");

                return $this->redirectToRoute("book:show", [
                    'id' => $book->getId(),
                ]);
            }
        }
        // Préparation de l'objet $form pour la vue twig
        $form = $form->createView();

        return $this->render('book/update.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }


    // DELETE 
    // --
    // path: /book/{id}/delete
    // name: book:delete
    /**
     * @Route("/{id}/delete", name="delete", methods={"HEAD", "GET", "DELETE"})
     */
    public function delete(Book $book, ManagerRegistry $doctrine, Request $request)
    {
        if ($request->getMethod() === 'DELETE') {
            // Requete de suppression
            $em = $doctrine->getManager();
            $em->remove($book);
            $em->flush();

            // Redirection de l'utilisateur
            return $this->redirectToRoute("book:index");
        }

        return $this->render('book/delete.html.twig', [
            'book' => $book
        ]);
    }
}
