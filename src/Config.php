<?php
/**
 * User: junade
 * Date: 14/08/2016
 * Time: 18:35
 */

namespace IcyApril\Tail;

class Config
{
    private $follow;

    public function __construct($file)
    {
        if ( ! is_file($file)) {
            throw new \Exception("Not file.");
        }

        $this->file = $file;
    }

    public function follow(bool $follow)
    {
        $this->follow = $follow;
    }

}