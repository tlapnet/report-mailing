# Report Mailing

## Installation

This extension is highly depending on [Contributte/Scheduler](https://github.com/contributte/scheduler) and [Contributte/Mailing](https://github.com/contributte/mailing), so take a look.

Register extensions.

```yaml
extensions:
    mailing: Contributte\Mailing\DI\MailingExtension
    scheduler: Contributte\Scheduler\DI\SchedulerExtension
    reportMailing: Tlapnet\ReportMailing\DI\ReportMailingExtension
```

Set-up crontab for scheduler. Use `scheduler:run` command.

```
* * * * * php path-to-project/console scheduler:run
```

## Processors

Use `IProcessor` interface. Every processor is registered as service in DIC, so you can use other services.

```php
class FromProcessor implements IProcessor
{

	/**
	 * @param MailBuilder $message
	 * @param mixed[] $meta
	 * @return MailBuilder
	 */
	public function processMessage(MailBuilder $message, $meta)
	{
		$message->setFrom($meta['mail'], isset($meta['name']) ? $meta['name'] : '');

		return $message;
	}

}
```

And don't forget register it in processors section.

```yaml
reportMailing:
    processors:
        from: App\Processor\FromProcessor
```

Then you can use custom type.

```yaml
    - {type: from, meta: {mail: johndoe@example.com, name: John Doe}}
```

## Feeds

Create feeds.

```yaml
reportMailing:
    feeds:

        reportX:
            mail:
                subject: Here is your report.
                to:
                    - mail@example.com
                template:
                    file:
                    params: []
                cron: * * * * *
                processors: 
                    - {type: from, meta: {mail: johndoe@example.com}}
```
