# Stopwatch

PHP tool that measures code execution time.

[README in Russian](docs/ru/README.md)

## Usage

```php
$stopwatch = new Almasmurad\Stopwatch\Stopwatch();

//... (measured code)

$stopwatch->report();
```

As a result, the following report gets into the standard output:

```
Started at Sat, 27 Jan 2024 06:55:14 +0000
‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
All time | 0.198s
```

### Output Report to File

To output report to a file, use `reportToFile()` method:

```php
$stopwatch = new Almasmurad\Stopwatch\Stopwatch();

//... (measured code)

$stopwatch->reportToFile(__DIR__.'/report.txt');
```
Report will be written to a file, and nothing will get into the standard output. If the file `report.txt ` already exists, the report will replace its contents.


## Additional Features

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


## Future Plans

Stopwatch will evolve and acquire additional features. An incomplete list of planned changes:
- Adding the `step()` method, which can be used to measure the time of each stage of the process.
- Adding the ability to output a report not only to standard output, but also to a local file.
- Adding the ability to measure not only time, but also peak memory usage.
- Adding the ability to measure a repeatable process when the `start()` and `stop()` methods are called multiple times.


## Learn more

- [The Principles by Which Stopwatch Was Created](docs/en/Principles.md)