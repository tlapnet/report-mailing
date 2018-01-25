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

## Feeds

Every set of emails is called feed. You need to set `cron` expression.
 
Optionally you can set `mail.to` (string|array), `mail.subject`, `mail.template.file`, `mail.template.params`. 

```yaml
reportMailing:
    feeds:

        reportX:
            cron: * * * * *
            mail:
                subject: Here is your report.
                to:
                    - mail@example.com
                    - mail2@example.com
                template:
                    file: %appDir%/templates/mail.latte 
                    params: []
            processors: 
                - {type: from, meta: {mail: johndoe@example.com}}
```

If you need customize more thing, you need to use processors.

## Processors

Processors are customizable services that append or changing something in mail. 

### To processor

```yaml
    - {type: to, meta: {to: [mail@example.com, mail2@example.com]}}
```

### Subject processor

```yaml
    - {type: subject, meta: {subject: Cool email!}}
```

### From processor

```yaml
    - {type: from, meta: {mail: johndoe@example.com, name: John Doe}}
```

### Template processor 

```yaml
    - {type: template, meta: {file: %appDir%/templates/mail.latte, params: []}}
```

### Custom processor

Or you can create your own processor. 

Use `IProcessor` interface. Every processor is registered as service in DIC, so you can use other services.

```php
class MyAwesomeProcessor implements IProcessor
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
        myAwesomeProcessor: App\Processor\MyAwesomeProcessor
```

Then you can use custom type.

```yaml
    - {type: myAwesomeProcessor, meta: {mail: johndoe@example.com, name: John Doe}}
```

## Global processors

Global processors are applied to all feeds.

```yaml
reportMailing:
    globalProcessors: 
        - {type: from, meta: {mail: johndoe@example.com}}
```
