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
    private $follow;

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
     * Indicates whether last lines of file should be actively tracked.
     *
     * @param bool $follow
     */
    public function follow(bool $follow)
    {
        $this->follow = $follow;
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
     * Get follow status.
     *
     * @return bool
     */
    public function getFollow(): bool
    {
        if ( ! isset($this->follow)) {
            return false;
        }

        return $this->follow;
    }
}