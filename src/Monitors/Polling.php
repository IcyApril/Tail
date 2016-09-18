<?php
/**
 * User: junade
 * Date: 14/08/2016
 * Time: 19:26
 */

namespace IcyApril\Tail;


class Polling implements Monitor
{
    private $lastUpdate;

    public function __construct(string $file)
    {
        if ( ! is_file($file)) {
            throw new \Exception("File does not exist.");
        }

        $this->lastUpdate = filemtime($file);
    }

    public function run()
    {
    }
}