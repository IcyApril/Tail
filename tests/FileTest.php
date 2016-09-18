<?php

/**
 * User: junade
 * Date: 14/08/2016
 * Time: 19:34
 */
class FileTest extends PHPUnit_Framework_TestCase
{
    public function testCountLines()
    {
        $fileLocation = tempnam(sys_get_temp_dir(), 'tailExists');

        file_put_contents($fileLocation, "Hello");
        $file = new \IcyApril\Tail\File($fileLocation);

        // Should be zero as it contains no EOLs: http://unix.stackexchange.com/questions/83408/why-does-wc-l-tell-me-that-this-non-empty-file-has-0-lines
        $this->assertEquals(0, $file->countLines());

        file_put_contents($fileLocation, "Hello" . PHP_EOL);
        $file = new \IcyApril\Tail\File($fileLocation);
        $this->assertEquals(1, $file->countLines());

        file_put_contents($fileLocation, "Hello\ntest");
        $file = new \IcyApril\Tail\File($fileLocation);
        $this->assertEquals(1, $file->countLines());

        file_put_contents($fileLocation, "Hello\ntest\ntest\n");
        $file = new \IcyApril\Tail\File($fileLocation);
        $this->assertEquals(3, $file->countLines());

        file_put_contents($fileLocation, "Hello" . PHP_EOL);
        $file = new \IcyApril\Tail\File($fileLocation);
        file_put_contents($fileLocation, "Hello" . PHP_EOL, FILE_APPEND);
        $this->assertEquals(2, $file->countLines());

        unlink($fileLocation);
    }

    public function testGetLastLines()
    {
        $fileLocation = tempnam(sys_get_temp_dir(), 'tailExists');
        file_put_contents($fileLocation, "Hello 1" . PHP_EOL . "Hello 2" . PHP_EOL . "Hello 3" . PHP_EOL);

        $file = new \IcyApril\Tail\File($fileLocation);

        $this->assertEquals($file->getLastLines(1, true), "Hello 3");
        $this->assertEquals($file->getLastLines(1, false), "Hello 3");

        $this->assertEquals($file->getLastLines(2, true), "Hello 2" . PHP_EOL . "Hello 3");
        $this->assertEquals($file->getLastLines(2, false), "Hello 2" . PHP_EOL . "Hello 3");

        $this->assertEquals($file->getLastLines(3, true), "Hello 1" . PHP_EOL . "Hello 2" . PHP_EOL . "Hello 3");
        $this->assertEquals($file->getLastLines(3, false), "Hello 1" . PHP_EOL . "Hello 2" . PHP_EOL . "Hello 3");

        $this->assertEquals($file->getLastLines(4, true), "Hello 1" . PHP_EOL . "Hello 2" . PHP_EOL . "Hello 3");
        $this->assertEquals($file->getLastLines(4, false), "Hello 1" . PHP_EOL . "Hello 2" . PHP_EOL . "Hello 3");

    }
}
