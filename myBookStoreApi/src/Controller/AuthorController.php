<?php

namespace App\Controller;

use App\Context\ControllerContext;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthorController extends ControllerContext
{

    /**
     * @Route("/author", name="app_author", methods={"HEAD", "GET"})
     */
    public function index(AuthorRepository $authorRepository, Request $request): JsonResponse
    {
        $authors = $authorRepository->findAll();

        foreach ($authors as $author_key => $author) {
            $books = $author->getBooks();

            foreach ($books as $book_key => $book) {
                $books[$book_key] = [
                    'id' => $book->getId(),
                    'title' => $book->getTitle(),
                    'href' => $this->urlGenerator->generate('app_book_show', ['id' => $book->getId()])

                ];
            }

            $authors[$author_key] = [
                'id' => $author->getId(),
                'firstname' => $author->getFirstname(),
                'lastname' => $author->getLastname(),
                'books' => $books,
                'href' => $this->urlGenerator->generate('app_author_show', ['id' => $author->getId()])
            ];
        }

        return $this->json($this->response($request, $authors, "authors"));
    }

    /**
     * @Route("/author", name="app_author_new", methods={"POST"})
     */
    public function new(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller POST!',
            'path' => 'src/Controller/AuthorController.php',
        ]);
    }

    /**
     * @Route("/author/{id}", name="app_author_show", methods={"GET"})
     */
    public function read(): JsonResponse
    {
        return $this->json([
            'author' =>  '',
        ]);
    }
    /**
     * @Route("/author/{id}", name="app_author_edit", methods={"PATCH"})
     */
    public function update(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller UPDATE!',
            'path' => 'src/Controller/AuthorController.php',
        ]);
    }
    /**
     * @Route("/author/{id}", name="app_author_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller DELETE!' . $id,
            'path' => 'src/Controller/AuthorController.php',
        ]);
    }
}
