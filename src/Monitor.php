<?php
/**
 * User: junade
 * Date: 14/08/2016
 * Time: 19:27
 */

namespace IcyApril\Tail;


interface Monitor
{
    public function __construct(string $file);

    public function run();
}