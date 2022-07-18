<?php

namespace App\Controller;

use App\Context\ControllerContext;
use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends ControllerContext
{

    /**
     * @Route("/book", name="app_book_index", methods={"HEAD", "GET"})
     */
    public function index(BookRepository $bookRepository, Request $request): JsonResponse
    {
        $books = $bookRepository->findAll();

        foreach ($books as $book_key => $book) {

            $authors = $book->getAuthors();
            foreach ($authors as $author_key => $author) {
                $authors[$author_key] = [
                    'id' => $author->getId(),
                    'firstname' => $author->getFirstname(),
                    'lastname' => $author->getLastname(),
                    'href' => $this->urlGenerator->generate('app_author_show', ['id' => $author->getId()])
                ];
            }

            $books[$book_key] = [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'authors' => $authors,
                'href' => $this->urlGenerator->generate('app_book_show', ['id' => $book->getId()])

            ];
        }

        return $this->json($this->response($request, $books, "books"));
    }


    /**
     * @Route("/book", name="app_book_show", methods={"HEAD", "GET"})
     */
    public function read(Book $book): JsonResponse
    {

        return $this->json([
            'book' => $book
        ]);
    }
}
