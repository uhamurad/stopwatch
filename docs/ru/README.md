# Stopwatch

PHP-инструмент, измеряющий время исполнение кода.

## Пример

```php
$stopwatch = new Almasmurad\Stopwatch\Stopwatch();

//... (измеряемый код)

$stopwatch->report();
```

В результате выводится отчёт:

```
Started at Sat, 27 Jan 2024 06:55:14 +0000
‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
All time | 0.198s
```

## Дополнительные возможности

С помощью методов `start()` и `stop()` можно измерить время работы отдельного участка кода:

```php
$stopwatch = new Almasmurad\Stopwatch\Stopwatch();
//... 
$stopwatch->start();   // запуск измерение

//... (измеряемый код)

$stopwatch->stop();    // остановка измерение
//... 
$stopwatch->report();
```


## Планы на будущее

Stopwatch будет развиваться и обрастать дополнительными функциями. Не плный список планируемых изменений:
- Добавление метода `step()`, с помощью которого можно измерять время каждого этапа изучаемого процесса
- Добавление возможности выводить отчёт не только в стандартный вывод, но и в локальный файл
- Добавление возможности измерять не только время, но и пиковое использование памяти
- Добавление возможности измерять повторяемого процесса, когда методы `start()` и `stop()` вызываются по нескольку раз