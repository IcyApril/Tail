<?php
/**
 * User: junade
 * Date: 14/08/2016
 * Time: 19:23
 */

namespace IcyApril\Tail;


class File
{
    private $handle;

    /**
     * File constructor.
     *
     * @param string $file
     *
     * @throws \Exception
     */
    function __construct(string $file)
    {
        if ( ! is_file($file)) {
            throw new \Exception("Not file.");
        }

        $this->handle = fopen($file, "r");
    }

    /**
     * Count the number of lines in a file.
     * @return int
     */
    public function countLines(): int
    {
        $lineCount = 0;

        $buffer = $this->getBuffer();

        while ( ! feof($this->handle)) {
            $line = fgets($this->handle, $buffer);

            $lineCount = $lineCount + substr_count($line, PHP_EOL);
        }

        return $lineCount;
    }

    /**
     * Get the last lines from a given file.
     *
     * @param int $lines
     * @param bool $adaptive
     *
     * @see http://stackoverflow.com/questions/15025875/what-is-the-best-way-in-php-to-read-last-lines-from-a-file
     *
     * @return string
     */
    public function getLastLines($lines = 10, $adaptive = true)
    {
        $buffer = $this->getBuffer($lines, $adaptive);

        // Jump to last character
        fseek($this->handle, -1, SEEK_END);

        // Read it and adjust line number if necessary
        // (Otherwise the result would be wrong if file doesn't end with a blank line)
        if (fread($this->handle, 1) != "\n") {
            $lines -= 1;
        }

        // Start reading
        $output = '';
        $chunk  = '';

        // While we would like more
        while (ftell($this->handle) > 0 && $lines >= 0) {

            // Figure out how far back we should jump
            $seek = min(ftell($this->handle), $buffer);

            // Do the jump (backwards, relative to where we are)
            fseek($this->handle, -$seek, SEEK_CUR);

            // Read a chunk and prepend it to our output
            $output = ($chunk = fread($this->handle, $seek)) . $output;

            // Jump back to where we started reading
            fseek($this->handle, -mb_strlen($chunk, '8bit'), SEEK_CUR);

            // Decrease our line counter
            $lines -= substr_count($chunk, "\n");

        }

        // While we have too many lines
        // (Because of buffer size we might have read too many)
        while ($lines++ < 0) {

            // Find first newline and remove all text before that
            $output = substr($output, strpos($output, "\n") + 1);

        }

        return trim($output);
    }

    function __destruct()
    {
        fclose($this->handle);
    }

    /**
     * Get size of buffer.
     *
     * @param $lines
     * @param $adaptive
     *
     * @return int
     */
    private function getBuffer($lines = 0, $adaptive = false): int
    {
        if ( ! $adaptive) {
            $buffer = 4096;

            return $buffer;
        }

        $buffer = ($lines < 2 ? 64 : ($lines < 10 ? 512 : 4096));
        return $buffer;
    }
}