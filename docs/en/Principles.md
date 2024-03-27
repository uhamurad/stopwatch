
The Principles by Which Stopwatch Was Created
========================

Minimum number of dependencies on external packages
------------------------------------------------------

The main project contains a minimum of dependencies on other composer packages.

And if additional functionality requires adding a dependency, it will be implemented as a separate composer package.

For example, if you have the ability to send reports using `Monolog`, a separate composer package will be created, e.g. `uhamurad/stopwatch-monolog`.

At the same time, the main package may contain modules using native PHP functions and classes, such as `file_put_contents()`, etc., which do not need adding new requirements to PHP extensions (such as `ext-json`).


Stopwatch does not throw errors and exceptions
------------------------------------------------------

All erroneous and exceptional situations should be reflected in the report and logs. They should not interrupt the main program (see [Notices](Notices.md) chapter).
