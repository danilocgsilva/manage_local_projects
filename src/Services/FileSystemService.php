<?php

declare(strict_types=1);

namespace App\Services;

use Psr\Log\LoggerInterface;

class FileSystemService
{
    public function createFolder(string $dirPath, ?LoggerInterface $logger)
    {
        if (is_dir($dirPath)) {
            if ($logger) {
                $logger->info(
                    sprintf('A folder called %s already exists. Maybe better not changing anything. Abort folder creation.', $dirPath)
                );
            }
            return false;
        }

        mkdir($dirPath);
        if ($logger) {
            $logger->info(sprintf("Folder %s created.", $dirPath));
        }
        return true;
    }

    public function write(
        string $fileContent, 
        string $fileName,
        string $fileSystemPath
    ): void
    {
        file_put_contents(
            $fileSystemPath . DIRECTORY_SEPARATOR . $fileName,
            $fileContent
        );
    }
}
