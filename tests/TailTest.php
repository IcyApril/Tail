<?php

/**
 * User: junade
 * Date: 19/09/2016
 * Time: 10:58
 */
class TailTest extends PHPUnit_Framework_TestCase
{
    public function testGetTail()
    {
        $fileLocation = tempnam(sys_get_temp_dir(), 'tailTest');
        file_put_contents($fileLocation, "Hello 1" . PHP_EOL . "Hello 2" . PHP_EOL . "Hello 3" . PHP_EOL);

        $config = new \IcyApril\Tail\Config($fileLocation);
        $config->setLines(2);

        $tail = new \IcyApril\Tail\Tail($config);
        $this->assertEquals("Hello 2" . PHP_EOL . "Hello 3", $tail->getTail());

        file_put_contents($fileLocation, "Hello 4" . PHP_EOL, FILE_APPEND | LOCK_EX);
        $this->assertEquals("Hello 4", $tail->getTail());

        file_put_contents($fileLocation, "Hello 5" . PHP_EOL . "Hello 6" . PHP_EOL, FILE_APPEND | LOCK_EX);
        $this->assertEquals("Hello 5" . PHP_EOL . "Hello 6", $tail->getTail());

        file_put_contents($fileLocation, "World 1" . PHP_EOL . "World 2" . PHP_EOL . "World 3" . PHP_EOL);
        $this->assertEquals("World 1" . PHP_EOL . "World 2" . PHP_EOL . "World 3", $tail->getTail());

        $config = new \IcyApril\Tail\Config($fileLocation);
        $config->setLines(0);

        $tail = new \IcyApril\Tail\Tail($config);
        $this->assertEquals("", $tail->getTail());

        file_put_contents($fileLocation, "World 4" . PHP_EOL);
        $this->assertEquals("World 4", $tail->getTail());
    }
}
