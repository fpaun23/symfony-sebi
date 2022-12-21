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
        $dataResponse = [];

        if (file_exists(self::FILE_PATH)) {
            $lines = file(self::FILE_PATH, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            if ($lines !== false) {
                foreach ($lines as $jobs) {
                    $job = explode(self::SEPARATOR, $jobs);
                    $dataResponse['jobs'][] =
                    [
                            'name' => $job[0],
                            'company_id' => $job[1],
                            'description' => $job[2],
                            'active' => $job[3],
                            'priority' => $job[4]
                    ];
                }
            } else {
                throw new \Exception('Error reading file');
            }
        } else {
            throw new \Exception('File does not exist');
        }
        print_r($dataResponse);
        return $dataResponse;
    }
}
