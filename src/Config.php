<?php
/**
 * User: junade
 * Date: 14/08/2016
 * Time: 18:35
 */

namespace IcyApril\Tail;

class Config
{
    private $file;
    private $lines;

    /**
     * Config constructor.
     *
     * @param $file
     *
     * @throws \Exception
     */
    public function __construct(string $file)
    {
        if ( ! is_file($file)) {
            throw new \Exception("Not file.");
        }

        $this->file = $file;
    }

    /**
     * Set amount of lines that should be initially read from tail.
     *
     * @param int $lines
     *
     * @throws \Exception
     */
    public function setLines(int $lines)
    {
        if ($lines < 0) {
            throw new \Exception("Line count must be a positive integer (0 acceptable).");
        }

        $this->lines = $lines;
    }

    /**
     * Get file which was set in constructor.
     *
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * Get line count to read, defaults to 0.
     *
     * @param int $lines
     *
     * @return int
     */
    public function getLines()
    {
        if ( ! isset($this->lines)) {
            return 0;
        }

        return $this->lines;
    }
}