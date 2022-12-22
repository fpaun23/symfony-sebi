<?php

declare(strict_types=1);

namespace App\Services\File;

interface FileReaderInterface
{
    public function getData(): array;
}
