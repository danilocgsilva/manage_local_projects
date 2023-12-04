<?php

declare(strict_types=1);

namespace App\Services;

interface FileSystemAdapterInterface
{
    public function mkdir(string $fullPath);
    
    public function writeFile(string $filePath, string $content);
}
