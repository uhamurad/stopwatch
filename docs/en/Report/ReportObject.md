Report Object
========================

Getting a Report Object
------------------------------------------------------

The result of Stopwatch is a report that can be obtained in the object view by calling the `getReport()` method:

```php
$stopwatch = new Almasmurad\Stopwatch\Stopwatch();

//... (measured code)

$report = $stopwatch->getReport();
```

The `$report` object provides access to the report components via methods:

| method             | type             | description                                                     |
|--------------------|------------------|-----------------------------------------------------------------|
| `getStartEvent()`  | `EventInterface` | Stopwatch countdown beginning event                             |
| `getFinishEvent()` | `EventInterface` | Stopwatch countdown end event                                   |
| `getAllTime()`     | `TimeInterface`  | The time elapsed from the beginning to the end of the countdown |

Events
------------------------------------------------------

The component of the `EventInterface` type (`Almasmurad\Stopwatch\Time\Common\EventInterface`) - an event that has the following methods:

| method           | type                | description                                            |
|------------------|---------------------|--------------------------------------------------------|
| `getTimestamp()` | `float`             | The date of the event in Unix time format              |
| `getDateTime()`  | `DateTimeInterface` | The date of the event in the form of a DateTime object |

Time Periods
------------------------------------------------------

The component of the `TimeInterface` (`Almasmurad\Stopwatch\Time\Common\TimeInterface`) - a time period that has the following method:

| method         | type             | description       |
|----------------|------------------|-------------------|
| `getSeconds()` | `float`          | number of seconds |

Example of using a report object:

```php
$report = $stopwatch->getReport();
$elapsed = $report->getAllTime()->getSeconds();
printf('Wow it spent %f seconds!', $elapsed);
```