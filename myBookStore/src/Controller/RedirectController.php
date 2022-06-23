<?php

namespace App\Controller;

use App\Service\GuessLocale;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RedirectController extends AbstractController
{
     public function redirectToLocale(GuessLocale $guessLocale): Response
     {
          $locale = null;

          // Deviner la mangue de l'utilisateur
          $guess = $guessLocale->fromBrowser();
          $guess = explode("-", $guess);
          $locale = $guess[0];
          $availableLocales = explode("|", $this->getParameter('available_locales'));
          // Controle que $guess[0] fait partie des locales disponibles
          foreach ($availableLocales as $availableLocale) {
               $locale = $availableLocale === $locale ? $availableLocale : "";
          }

          // Recupération de la locale par defaut definit dans le fichier "service.yaml
          if (!$locale) {
               $locale = $this->getParameter('default_locale');
          }

          // Redirection de l'utilisateur vers la route "Homepage" avec le partamètre de langue part defaut
          return $this->redirectToRoute('app_homepage', [
               '_locale' => $locale
          ]);
     }
}
