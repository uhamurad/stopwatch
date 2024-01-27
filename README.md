# Stopwatch
Component for measuring code execution time

> !!! component is still in development !!!


## Simple example

```php
use Almasmurad\Stopwatch\Stopwatches;

$stopwatch = Stopwatches::simple();


$stopwatch->start();

$wrongText = file_get_contents('PiratesOfTheCaribbean.txt');
$rightText = substr_replace('Jack Sparrow', 'Captain Jack Sparrow', $wrongText);
file_put_contents('PiratesOfTheCaribbean.txt');

$stopwatch->stop()->report();

```

outputs

```
Started at Sat, 27 Jan 2024 06:55:14 +0000
‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
All time | 0.198s

```


## Example with steps

```php
use Almasmurad\Stopwatch\Stopwatches;

$stopwatch = Stopwatches::simple();


$stopwatch->start();

$wrongText = file_get_contents('PiratesOfTheCaribbean.txt');
$stopwatch->step('loaded text');                               // <-- ADDED

$rightText = substr_replace('Jack Sparrow', 'Captain Jack Sparrow', $wrongText);
$stopwatch->step('fixed text');                                // <-- ADDED

file_put_contents('PiratesOfTheCaribbean.txt');
$stopwatch->step('saved text');                                // <-- ADDED

$stopwatch->stop()->report();

```

outputs

```
Started at Sat, 27 Jan 2024 06:55:14 +0000
‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
Steps       | Time  
--------------------
loaded text | 0.020s
fixed text  | 0.166s
saved text  | 0.012s
--------------------
All time    | 0.198s

```


## Example with peak memory measuring

```php
use Almasmurad\Stopwatch\Stopwatches;

$stopwatch = Stopwatches::simple()
    ->withPeakMemoryMeasure();                                 // <-- ADDED


$stopwatch->start();

// ...

$stopwatch->stop()->report();

```

outputs

```
Started at Sat, 27 Jan 2024 06:55:14 +0000
‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
Steps       | Time   | Peak memory  
----------------------------------
loaded text | 0.020s |        21 B
fixed text  | 0.166s |    25 839 B
saved text  | 0.012s |       117 B
----------------------------------
All time    | 0.198s |    25 839 B

```
