<?php

/**
 * User: junade
 * Date: 18/09/2016
 * Time: 21:48
 */
class ConfigTest extends PHPUnit_Framework_TestCase
{

    public function testGetFile()
    {
        $fileLocation = tempnam(sys_get_temp_dir(), 'fileExists');
        file_put_contents($fileLocation, "test");
        $config = new \IcyApril\Tail\Config($fileLocation);
        $this->assertInstanceOf(\IcyApril\Tail\Config::class, $config);
        $this->assertEquals($fileLocation, $config->getFile());

        $this->expectException(Exception::class);
        new \IcyApril\Tail\Config($fileLocation . 'NoExist');
    }

    public function testSetLines()
    {
        $fileLocation = tempnam(sys_get_temp_dir(), 'followTest');
        $config = new \IcyApril\Tail\Config($fileLocation);
        $this->assertEquals(0, $config->getLines());

        $config->setLines(0);
        $this->assertEquals(0, $config->getLines());

        $config->setLines(1);
        $this->assertEquals(1, $config->getLines());

        $config->setLines(10);
        $this->assertEquals(10, $config->getLines());

        $this->expectException(Exception::class);
        $config->setLines(-1);
    }
}
