<?php

namespace App\Context;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ControllerContext extends AbstractController
{
     protected $urlGenerator;

     public function __construct(UrlGeneratorInterface $urlGenerator)
     {
          $this->urlGenerator = $urlGenerator;
     }

     public function response(Request $request, $data, string $index): array
     {
          $response = [];

          $response['header'] = [];
          $response['header']['datetime'] = date('Y-m-d H:i:s');
          $response['header']['timestamp'] = time();
          $response['header']['status'] = [];
          $response['header']['status']['code'] = Response::HTTP_OK;
          $response['header']['status']['text'] = Response::$statusTexts[Response::HTTP_OK];
          $response['header']['endpoint'] = $request->getScheme() . "://" . $request->getHttpHost();

          $response['content'] = [];
          $response['content'][$index] = $data;
          $response['content']['pages'] = [];
          $response['content']['pages']['current'] = "/" . $index . "?page=10";
          $response['content']['pages']['perPage'] = 20;
          $response['content']['pages']['current'] = 10;
          $response['content']['pages']['first'] = "/" . $index . "?page=1";
          $response['content']['pages']['prev'] = "/" . $index . "?page=9";
          $response['content']['pages']['next'] = "/" . $index . "?page=11";
          $response['content']['pages']['last'] = "/" . $index . "?page=42";

          return $response;
     }
}
