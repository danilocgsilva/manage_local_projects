<?php

declare(strict_types=1);

namespace App\Services;

class FileSystemAdapter implements FileSystemAdapterInterface
{
    public function mkdir(string $fullPath): void
    {
        mkdir($fullPath);
    }
    
    public function writeFile(string $filePath, string $content)
    {

    }
}
