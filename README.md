[![Build Status](https://travis-ci.org/IcyApril/Tail.svg?branch=master)](https://travis-ci.org/IcyApril/Tail)
[![Code Climate](https://codeclimate.com/github/IcyApril/Tail/badges/gpa.svg)](https://codeclimate.com/github/IcyApril/Tail)
[![Test Coverage](https://codeclimate.com/github/IcyApril/Tail/badges/coverage.svg)](https://codeclimate.com/github/IcyApril/Tail/coverage)
[![Issue Count](https://codeclimate.com/github/IcyApril/Tail/badges/issue_count.svg)](https://codeclimate.com/github/IcyApril/Tail)

# PHP Tail Library

A PHP Library for tailing files, supporting PHP 7.0 and above.

Currently, this library allows you to get the tail of a given file. Subsequent calls to the ````getTail```` function
will return whatever has been appended since the last call.

## Usage

Firstly let's create some random file with 3 lines of text.

```php
$fileLocation = tempnam(sys_get_temp_dir(), 'tailTest');
file_put_contents($fileLocation, "Hello 1" . PHP_EOL . "Hello 2" . PHP_EOL . "Hello 3" . PHP_EOL);
```

Now we can instantiate the Tail Config class and inject it into the constructor of the Tail operator, then run the
````getTail```` function:

```php
$config = new \IcyApril\Tail\Config($fileLocation);
$config->setLines(2);

$tail = new \IcyApril\Tail\Tail($config);
echo $tail->getTail();
```

The output of this will be the final two lines of the file we created:

````
Hello 2
Hello 3
````

Suppose we then append a line to the file:

```php
file_put_contents($fileLocation, "Hello 4" . PHP_EOL, FILE_APPEND | LOCK_EX);
```

Running ````getTail```` again will yield ````Hello 4````:

```php
echo $tail->getTail();
// Hello 4
```


## When to run getTail?

You can decide when to call the ````getTail```` function by either using the ````inotify```` watcher or simply using
polling with the ````filemtime()```` function.

## Caveats

* The output is based on line count. If your file has 15 lines to start with, then has 17; the last 2 will be displayed
at the next ````getTail```` call.
* If a file is over-written and therefore has less than the amount of lines than it started with; the entire new file
 will be returned at the next ````getTail```` call.
* Obviously you need to have your own polling/monitoring to decide when to call ````getTail````