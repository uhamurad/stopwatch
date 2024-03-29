Объект отчёта
========================

Получение объекта отчёта
------------------------------------------------------

Результатом работы Stopwatch является отчёт, который в объектном представлении можно получить, вызвав метод `getReport()`:

```php
$stopwatch = new Almasmurad\Stopwatch\Stopwatch();

//... (измеряемый код)

$report = $stopwatch->getReport();
```

Объект `$report` предоставляет доступ к составляющим отчета через методы:

| метод              | тип              | описание                                                            |
| ------------------ | ---------------- |---------------------------------------------------------------------|
| `getStartEvent()`  | `EventInterface` | событие начала отсчёта работы Stopwatch                             |
| `getFinishEvent()` | `EventInterface` | событие конца отсчёта работы Stopwatch                              |
| `getAllTime()`     | `TimeInterface`  | время, прошедшее от начала до конца отсчёта                         |
| `getNotices()`     | `string[]`       | список предупреждений (см. раздел [Предупреждения](../Notices.md))  |


События
------------------------------------------------------

Объект-составляющее отчёта типа `EventInterface` (интерфейс `Almasmurad\Stopwatch\Event\Common\EventInterface`) - событие, имеет следующие методы:

| метод              | тип                 | описание                              |
|--------------------|---------------------|---------------------------------------|
| `getTimestamp()`   | `float`             | дата события в формате Unix time      |
| `getDateTime()`    | `DateTimeInterface` | дата события в форме объекта DateTime |


Периоды времени
------------------------------------------------------

Объект-составляющее отчёта типа `TimeInterface` (интерфейс `Almasmurad\Stopwatch\Time\Common\TimeInterface`) - период времени, имеет следующие методы:

| метод          | тип                 | описание          |
|----------------|---------------------|-------------------|
| `getSeconds()` | `float`             | количество секунд |

Пример использования объекта отчёта:

```php
$report = $stopwatch->getReport();
$elapsed = $report->getAllTime()->getSeconds();
printf('Ух ты, прошло %f секунд!', $elapsed);
```