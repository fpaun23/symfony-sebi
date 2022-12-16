<?php

declare(strict_types=1);

namespace App\Service;
/**
 * Summary of FileReaderInterface
 */
interface FileReaderInterface
{
    /**
     * Function to read the jobs from the file
     *
     * @return array
     */
    private function _getData():array;
    
}