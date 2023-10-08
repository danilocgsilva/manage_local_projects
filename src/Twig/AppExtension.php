<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('currentSystem', [$this, 'getCurrentSystem']),
        ];
    }

    public function getCurrentSystem(): string|null
    {
        $results = shell_exec("uname -n");
        return $results;
    }
}
