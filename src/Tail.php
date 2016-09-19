<?php
/**
 * User: junade
 * Date: 14/08/2016
 * Time: 18:33
 */

namespace IcyApril\Tail;


class Tail
{
    private $observers;
    private $config;
    private $lineCount;

    /**
     * Tail constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->observers = new \SplObjectStorage();
        $this->config    = $config;
        $this->file      = new File($config->getFile());
    }

    /**
     * Gets the tail of the file.
     *
     * @return string
     */
    public function getTail(): string
    {
        $linesToPrint = $this->getLineCountToShow();

        return $this->file->getLastLines($linesToPrint);
    }

    /**
     * Gets the amount of lines that should be shown by the getTail function.
     *
     * @return int
     */
    private function getLineCountToShow(): int
    {
        if ( ! isset($this->lineCount)) {
            $this->lineCount = $this->file->countLines();

            return $this->config->getLines();
        }

        $newLineCount    = $this->file->countLines();
        $linesToPrint    = $newLineCount - $this->lineCount;
        $this->lineCount = $newLineCount;

        if ($linesToPrint < 0) {
            $linesToPrint = $newLineCount;
        }

        return $linesToPrint;
    }
}