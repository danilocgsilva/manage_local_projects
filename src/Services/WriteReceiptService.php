<?php

declare(strict_types=1);

namespace App\Services;
use App\Entity\Receipt;

class WriteReceiptService
{
    public function writeReceipt(
        FileSystemService $fileSystemService,
        Receipt $receipt,
        string $fileSystemToWrite,
    ): void
    {
        foreach ($receipt->getReceiptFiles() as $receiptFile) {
            $fileSystemService->write(
                $receiptFile->getContent(),
                $receiptFile->getPath(),
                $fileSystemToWrite
            );
        }
    }
}
