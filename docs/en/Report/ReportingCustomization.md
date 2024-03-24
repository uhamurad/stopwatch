Reporting customization
========================

Configuring Report Sending
------------------------------------------------------

Stopwatch provides 2 ways to send a report on the results of its work:

1. calling the `report()` method that outputs the report to the standard output stream,
2. calling the `reportToFile()` method that outputs the report to a file.

However, you can define your own way of sending the report. To do this, you first need to write a class that implements the `\Almasmurad\Stopwatch\Report\Sender\Common\ReportSenderInterface` interface. Below is an example of such a class that allows you to send a report by email:

```php
use Almasmurad\Stopwatch\Report\Sender\Common\ReportSenderInterface;

class EmailReportSender implements ReportSenderInterface
{
    public function send(string $report)
    {
        mail('reports@example.com', 'Stopwatch report', $report);
    }
}
```

The text of the report is passed in the `$report` parameter of the `send()` method.

Next, you need to tell Stopwatch to use our new class. There are 2 ways to do this:

1. Using the constructor:
   ```php
   $stopwatch = new \Almasmurad\Stopwatch\Stopwatch(new EmailReportSender);
   ```

2. Using the `setReportSender()` method:
   ```php
   $stopwatch->setReportSender(new EmailReportSender);
   ```

Now, when calling the `report()` method, the report will be sent to email instead of being output to the standard stream.

```php
$stopwatch = new Almasmurad\Stopwatch\Stopwatch();

//... (measured code)

$stopwatch->setReportSender(new EmailReportSender)->report();  // -> report is sent by email
```

Configuring Report Rendering
--------------------------------------------------------------

By default, the text of the Stopwatch report looks something like this:

```
Started at Sat, 27 Jan 2024 06:55:14 +0000
‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
All time | 0.198s
```

However, we can change the way the report text is generated. To do this, you first need to write a class that implements the `\Almasmurad\Stopwatch\Report\Renderer\Common\ReportRendererInterface` interface. Below is an example of such a class:

```php
use Almasmurad\Stopwatch\Report\Common\ReportInterface;
use Almasmurad\Stopwatch\Report\Renderer\Common\ReportRendererInterface;

class OneLineReportRenderer implements ReportRendererInterface
{
    public function render(ReportInterface $report): string
    {
        $start = $report->getStartEvent()->getDateTime()->format('H:i:s');
        $duration = (int)$report->getAllTime()->getSeconds();
        
        return "Stopwatch started at {$start} and ran for {$duration} full seconds";
    }
}
```

The `$report` parameter of the `render()` method passes a report object containing all the necessary information for its formation. You can read more about the report object in the section '[Report object](Report/ReportObject.md)'

Next, you need to tell Stopwatch to use our new class. There are 2 ways to do this:

1. Using the constructor:

   ```php
   $stopwatch = new \Almasmurad\Stopwatch\Stopwatch(null, new OneLineReportRenderer);
   ```

2. Using the `setReportRenderer()` method:

   ```php
   $stopwatch->setReportRenderer(new OneLineReportRenderer);
   ```

Now, when calling the `report()` or the `reportToFile()` method a report of approximately the following type will be generated:

```
Stopwatch started at 09:11:48 and ran for 5 full seconds
```

