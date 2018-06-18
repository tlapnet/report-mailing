<?php declare(strict_types = 1);

namespace Tlapnet\ReportMailing\Processor;

use Contributte\Mailing\MailBuilder;

class SubjectProcessor implements IProcessor
{

	/**
	 * @param mixed[] $meta
	 */
	public function processMessage(MailBuilder $message, array $meta): MailBuilder
	{
		$message->setSubject($meta['subject']);
		return $message;
	}

}
