<?php

namespace Tlapnet\ReportMailing\Processor;

use Contributte\Mailing\MailBuilder;

class TemplateProcessor implements IProcessor
{

	/**
	 * @param MailBuilder $message
	 * @param mixed[] $meta
	 * @return MailBuilder
	 */
	public function processMessage(MailBuilder $message, $meta)
	{
		$message->setTemplateFile($meta['file']);
		$message->setParameters($meta['params']);
		return $message;
	}

}
