<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\FileReaderTXT;

class JobsService implements
{
    private FileReaderTXT $_fileReader;
    
    /**
     * __construct 
     *
     * @param mixed $fileReader 
     * 
     * @return void
     */
    public function __construct(
        FileReaderTXT $fileReader
    ) {
        $this->$_fileReader = $fileReader;
    }

}