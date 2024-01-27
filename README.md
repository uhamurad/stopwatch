# stopwatch
Component for measuring code execution time


# Simple example

```php
use Almasmurad\Stopwatch\Stopwatches;

$stopwatch = Stopwatches::simple();

$stopwatch->start();

$wrongText = file_get_contents('PiratesOfTheCaribbean.txt');
$rightText = substr_replace('Jack Sparrow', 'Captain Jack Sparrow', $wrongText);
file_put_contents('PiratesOfTheCaribbean.txt');

$stopwatch->stop();

echo $stopwatch->report();

```

outputs

```
Started at Sat, 27 Jan 2024 06:55:14 +0000
------------------------------------------
Time: 0.198 sec

```
