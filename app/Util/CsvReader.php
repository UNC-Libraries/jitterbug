<?php

namespace Jitterbug\Util;

class CsvReader
{
    protected $filePath;

    /**
     * Create a new CsvReader instance.
     *
     * @param  string  $filePath  The path to the csv file to parse.
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * For each row, return an array of key/value pairs for the
     * given keys.
     *
     * @param  array  $keys  Array of keys to fetch data for. Keys should
     *                       be heading names in the CSV file.
     * @return array
     */
    public function fetchKeys($keys)
    {
        $fileHandle = fopen($this->filePath, 'r');
        $headRow = fgetcsv($fileHandle);
        $data = [];
        while ($fileRow = fgetcsv($fileHandle)) {
            $dataRow = [];
            foreach ($fileRow as $index => $column) {
                if (in_array($headRow[$index], $keys)) {
                    $dataRow[$headRow[$index]] = $column;
                }
            }
            $data[] = $dataRow;
        }
        fclose($fileHandle);

        return $data;
    }
}
