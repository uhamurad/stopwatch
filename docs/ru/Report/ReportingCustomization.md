Кастомизация работы с отчётом
========================

Настройка способа отправки отчёта
------------------------------------------------------

Stopwatch предоставляет 2 способа отправки отчёта о результатах своей работы:

1. вызов метода `report()`, который выводит отчёт в стандартный поток вывода,
2. вызов метода `reportToFile()`, который выводит отчёт в файл.

Однако вы можете определить собственный способ отправки отчёта.

Для этого сначала необходимо написать класс, реализующий интерфейс `\Almasmurad\Stopwatch\Report\Sender\Common\ReportSenderInterface`. Ниже представлен пример такого класса, который позволяет отправить отчёт на email:

```php
use Almasmurad\Stopwatch\Report\Sender\Common\ReportSenderInterface;

class EmailReportSender implements ReportSenderInterface
{
    public function send(string $report)
    {
        mail('reports@example.com', 'Отчёт Stopwatch', $report);
    }
}
```

В  параметре `$report` метода `send()` передается текст отчёта.

Далее, нужно указать Stopwatch использовать наш новый класс. Существует 2 способа это сделать:

1. Через конструктор:
   ```php
   $stopwatch = new \Almasmurad\Stopwatch\Stopwatch(new EmailReportSender);
   ```

2. С помощью метода `setReportSender()`:
   ```php
   $stopwatch->setReportSender(new EmailReportSender);
   ```

Теперь, при вызове метода `report()` отчёт будет отправляться на email вместо того, чтобы выводиться в стандартный поток.

```php
$stopwatch = new Almasmurad\Stopwatch\Stopwatch();

//... (измеряемый код)

$stopwatch->setReportSender(new EmailReportSender)->report();  // -> отчёт отправляется на email
```

Настройка формирования отчёта
--------------------------------------------------------------

По-умолчанию, текст отчета о работе Stopwatch выглядит приблизительно так:

```
Started at Sat, 27 Jan 2024 06:55:14 +0000
‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
All time | 0.198s
```

Однако мы можем изменить способ формирования текста отчёта. 

Для этого сначала необходимо написать класс, реализующий интерфейс `\Almasmurad\Stopwatch\Report\Renderer\Common\ReportRendererInterface`. Ниже представлен пример такого класса:

```php
use Almasmurad\Stopwatch\Report\Common\ReportInterface;
use Almasmurad\Stopwatch\Report\Renderer\Common\ReportRendererInterface;

class OneLineReportRenderer implements ReportRendererInterface
{
    public function render(ReportInterface $report): string
    {
        $start = $report->getStartEvent()->getDateTime()->format('H:i:s');
        $duration = (int)$report->getAllTime()->getSeconds();
        
        return "Stopwatch начал работу в {$start} и проработал {$duration} полных секунд";
    }
}
```

В параметре `$report` метода `render()` передается объект отчёта, содержащий всю необходимую информацию для его формирования. Подробнее об объекте отчета можно почитать в разделе "[Объект отчёта](Report/ReportObject.md)"

Далее, нужно указать Stopwatch использовать наш новый класс. Существует 2 способа это сделать:

1. Через конструктор:

   ```php
   $stopwatch = new \Almasmurad\Stopwatch\Stopwatch(null, new OneLineReportRenderer);
   ```

2. С помощью метода `setReportRenderer()`:

   ```php
   $stopwatch->setReportRenderer(new OneLineReportRenderer);
   ```

Теперь, при вызове метода `report()`  или метода `reportToFile()` будет формироваться отчёт приблизительно такого вида:

```
Stopwatch начал работу в 09:11:48 и проработал 5 полных секунд
```

