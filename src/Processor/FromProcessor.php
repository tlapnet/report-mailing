<?php

namespace Tlapnet\ReportMailing\Processor;

use Contributte\Mailing\MailBuilder;

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
