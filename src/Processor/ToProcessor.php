<?php declare(strict_types = 1);

namespace Tlapnet\ReportMailing\Processor;

use Contributte\Mailing\MailBuilder;

class ToProcessor implements IProcessor
{

	/**
	 * @param mixed[] $meta
	 */
	public function processMessage(MailBuilder $message, array $meta): MailBuilder
	{
		foreach ($meta['to'] as $to) {
			$message->addTo($to);
		}
		return $message;
	}

}
