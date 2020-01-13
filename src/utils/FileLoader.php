<?php
declare(strict_types=1);

namespace TaskForce\utils;

use TaskForce\exceptions\FileFormatException;
use TaskForce\exceptions\SourceFileException;

class FileLoader
{
    private string $filename;
    private array $columns;
    private $fp;

    private array $result = [];
    private $error = null;

    public function __construct(string $filename, array $columns)
    {
        $this->filename = $filename;
        $this->columns = $columns;
    }

    public function import():void
    {
        /**
         *** Check columns list
         */
        if (!$this->validateColumns($this->columns)) {
            throw new FileFormatException('Заданы неверные заголовки столбцов');
        }
        /**
         *** Check if file exists
         */
        if (!file_exists($this->filename)) {
            throw new SourceFileException('Файл не существует');
        }

        $this->fp = fopen($this->filename, 'r');

        if (!$this->fp) {
            throw new SourceFileException('Не удалось открыть файл на чтение');
        }

        $header_data = $this->getHeaderData();

        if (count($header_data) !== count($this->columns)) {
            throw new FileFormatException('Исходный файл не содержит необходимых столбцов');
        }


        while ($line = $this->getNextLine()) {
            $this->result[] = $line;
        }
    }

    public function getData():array {
        return $this->result;
    }

    private function getHeaderData():?array
    {
        rewind($this->fp);

        return fgetcsv($this->fp);
    }

    private function getNextLine()
    {
        $result = null;

        if (!feof($this->fp)) {
            $result = fgetcsv($this->fp);
        }

        return $result;
    }

    private function validateColumns(array $columns):bool
    {
        $result = true;

        if (count($columns)) {
            foreach ($columns as $column) {
                if (!is_string($column)) {
                    $result = false;
                }
            }
        }
        else {
            $result = false;
        }
        return $result;
    }
}
