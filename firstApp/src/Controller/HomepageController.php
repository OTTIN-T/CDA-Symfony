<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/homepage", name="app_homepage")
     */
    public function index(): Response
    {
        return $this->render('homepage/index.html.twig', [
            'now' => new DateTime(),
            'html' => "hello <strong>There</strong>",
            'array' => [
                'firstname' => "John",
                'lastname' => "Doe"
            ]
        ]);
    }
}
