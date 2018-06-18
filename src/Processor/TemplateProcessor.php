<?php declare(strict_types = 1);

namespace Tlapnet\ReportMailing\Processor;

use Contributte\Mailing\MailBuilder;

class TemplateProcessor implements IProcessor
{

	/**
	 * @param mixed[] $meta
	 */
	public function processMessage(MailBuilder $message, array $meta): MailBuilder
	{
		$message->setTemplateFile($meta['file']);
		$message->setParameters($meta['params']);
		return $message;
	}

}
