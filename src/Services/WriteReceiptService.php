<?php

declare(strict_types=1);

namespace App\Services;
use App\Entity\Receipt;

class WriteReceiptService
{
    public function writeReceipt(
        FileSystemService $fileSystemService,
        Receipt $receipt,
        string $fileSystemPathBase,
        ?string $dockerVolumePath,
        ?string $gitHubPath
    ): void
    {
        foreach ($receipt->getReceiptFiles() as $receiptFile) {
            $fileSystemService->write(
                $receiptFile->getContent(),
                $receiptFile->getPath(),
                $fileSystemPathBase
            );
        }
        if ($dockerVolumePath && $gitHubPath) {
            $pathToClone = $fileSystemPathBase . DIRECTORY_SEPARATOR . $dockerVolumePath;
            $shellCommand = "git clone " . $gitHubPath . " " . $pathToClone . " 2>&1 ";
            // $results = shell_exec($shellCommand);
            $results = exec($shellCommand);
        }
    }
}
