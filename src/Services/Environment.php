<?php

declare(strict_types=1);

namespace App\Services;

class Environment
{
    public function getUnameN(): string
    {
        return shell_exec("uname -n");
    }

    public function getUnameA(): string
    {
        return shell_exec("uname -a");
    }
}

