<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CopyrightExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('copyright', [$this, 'doCopyright'], ['is_safe' => ['html']]),
        ];
    }

    public function doCopyright(string $name, ?int $date = null): string
    {
        $currentDate = date('Y');

        return  $date < $currentDate ? "&copy; $date - $currentDate $name." : "&copy; $currentDate $name.";
    }
}
