<?php

namespace App\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Intl\Locales;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class LanguageExtension extends AbstractExtension
{

    private $container;
    private $environment;

    public function __construct(ContainerInterface $container, Environment $environment)
    {
        $this->container = $container;
        $this->environment = $environment;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('select_language', [$this, 'doSelectLanguage'], ['is_safe' => ['html']]),
            new TwigFunction('get_locales', [$this, 'doGetLocales']),
        ];
    }

    public function doGetLocales(): array
    {

        // Recupère les langues definies dans le fichier services.yaml
        $available_locales = $this->container->getParameter('available_locales');
        $available_locales = explode('|', $available_locales);


        // Déclaration du tableau de stockages des langue (code + nom)
        $locales = [];

        // Sur la liste des langues dispo...
        foreach ($available_locales as $locale) {
            // Recupération du code langue
            $code = $locale;

            // Recupération + formattage du nom de la langue
            $name = Locales::getName($locale, $locale);
            $name = ucfirst(strtolower($name));

            // Ajout des données de langues au tableau ^locales
            array_push($locales, [
                'code' => $code,
                'name' => $name,
            ]);
        }


        return $locales;
    }

    public function doSelectLanguage(): string
    {

        $languages =  ['fr', 'en', 'de'];
        return $this->environment->render('components/language/select.html.twig', ['languages' => $languages]);
    }
}
