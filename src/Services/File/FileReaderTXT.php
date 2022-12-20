<?php

declare(strict_types=1);

namespace App\Services\File;

use App\Services\File\FileReaderInterface;

class FileReaderTXT implements FileReaderInterface
{
    private const FILE_NAME = 'jobs.txt';
    private const FILE_PATH = __DIR__ . '/' . self::FILE_NAME;
    private const SEPARATOR = ',';
    /**
     * Read a file from a text
     *
     * @return array
     */
    public function getData(): array
    {
        if (!file_exists(self::FILE_PATH)) {
            throw new \Exception('File does not exist');
        }

        $lines = file(self::FILE_PATH, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($lines == false) {
            throw new \Exception('Error reading file');
        }

        foreach ($lines as $jobs) {
            $job = explode(self::SEPARATOR, $jobs);
            $readFile = [
                'jobs' => [
                    'name' => $job[0],
                    'description' => $job[1],
                    'priority' => $job[2],
                    'active' => $job[3],
                    'company_id' => $job[4]
                ]
            ];
            print_r($readFile);
        }
        return $readFile;
    }
}
