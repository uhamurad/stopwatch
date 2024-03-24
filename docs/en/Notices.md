
Notices
========================

If unforeseen situations occur while Stopwatch is running, or if its methods were called in the wrong order, the main program will not be interrupted by throwing exceptions or PHP errors. 

Instead, the problem messages end up in a special section of the report - Notices.

Consider the following example:

```php
$stopwatch = new Almasmurad\Stopwatch\Stopwatch();
$stopwatch->start();     // start measuring
$stopwatch->finish();    // finish measuring
$stopwatch->finish();    // !!! error - repeated calling the finish() method 
$stopwatch->report();
```

In this example, the `finish()` method is called 2 times. This is an erroneous situation, and a warning about its occurrence will be contained in the report:

```
Started at Sat, 27 Jan 2024 06:55:14 +0000
‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
All time | 0.198s
——————————————————————————————————————————
Notices:
 - finish() method calling was skipped, because Stopwatch is already finished
```

Using the `getNotices()` method, you can get the text of all notices:

```php
$report = $stopwatch->getReport();

$allNotices = $report->getNotices();
foreach ($allNotices as $notice) {
    printf("Pay attention to the notice: %s\n", $notice);
}
```
