<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function __construct(private ContainerInterface $container)
    {
    }
    
    public function getFunctions(): array
    {
        return [
            new TwigFunction('currentSystem', [$this, 'getCurrentSystem']),
        ];
    }

    public function getCurrentSystem(): string|null
    {
        return $this->container->get('environment')->getUnameN();
    }
}
