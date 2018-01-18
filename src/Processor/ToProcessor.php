<?php

namespace Tlapnet\ReportMailing\Processor;

use Contributte\Mailing\MailBuilder;

class ToProcessor implements IProcessor
{

	/**
	 * @param MailBuilder $message
	 * @param mixed[] $meta
	 * @return MailBuilder
	 */
	public function processMessage(MailBuilder $message, $meta)
	{
		foreach ($meta['to'] as $to) {
			$message->addTo($to);
		}
		return $message;
	}

}
