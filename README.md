# Stopwatch

PHP tool that measures code execution time.

[README in Russian](docs/ru/README.md)

## Usage

```php
$stopwatch = new Almasmurad\Stopwatch\Stopwatch();

//... (measured code)

$stopwatch->report();
```

The result is a report:

```
Started at Sat, 27 Jan 2024 06:55:14 +0000
‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
All time | 0.198s
```

## Additional features

Using the `start()` and `stop()` methods, you can measure a separate section of the code:

```php
$stopwatch = new Almasmurad\Stopwatch\Stopwatch();
//... 
$stopwatch->start();   // start measuring

//... (measured code)

$stopwatch->stop();    // stop measuring
//... 
$stopwatch->report();
```


## Future plans

Stopwatch will evolve and acquire additional features. An incomplete list of planned changes:
- Adding the `step()` method, which can be used to measure the time of each stage of the process.
- Adding the ability to output a report not only to standard output, but also to a local file.
- Adding the ability to measure not only time, but also peak memory usage.
- Adding the ability to measure a repeatable process when the `start()` and `stop()` methods are called multiple times.
