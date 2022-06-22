<?php

namespace App\Service;

class GuessLocale
{
     public function fromBrowser(): ?string
     {

          $http_accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
          if (empty($http_accept_language)) return null;
          $http_accept_language = explode(",", $http_accept_language);

          foreach ($http_accept_language as $index => $value) {
               $value = explode(";", $value);

               $language = $value[0];

               $score = $value[1] ?? 1;
               $score = (float) filter_var($score, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

               $http_accept_language[$index] = [
                    'language' => $language,
                    'score' => $score
               ];
          }
          uasort($http_accept_language, [$this, 'cmp']);
          $http_accept_language = array_values($http_accept_language);

          if (!isset($http_accept_language[0])) return null;
          if (!isset($http_accept_language[0]['language']) || empty($http_accept_language[0]['language'])) return null;

          return $http_accept_language[0]['language'];
     }

     private function cmp($a, $b): int
     {
          if ($a['score']  === $b['score']) {
               return 0;
          }
          return ($a['score'] > $b['score']) ? -1 : 1;
     }
}
