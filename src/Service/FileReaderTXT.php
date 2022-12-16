<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\FileReaderInterface;

class FileReaderTXT implements FileReaderInterface
{
    const FILE_NAME = 'jobs.txt';
    const FILE_PATH = __DIR__ . '/' . self::FILE_NAME;
    /**
     * Read a file from a text
     *
     * @return array
     */
    private function _getData():array
    {
        if (!file_exists(self::FILE_PATH)) {
            throw new \Exception('File does not exist');
        }
        
        $readfile = file("src\Service\jobs.txt");
        return $readfile;
    }
}