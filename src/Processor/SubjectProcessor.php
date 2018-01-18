<?php

namespace Tlapnet\ReportMailing\Processor;

use Contributte\Mailing\MailBuilder;

class SubjectProcessor implements IProcessor
{

	/**
	 * @param MailBuilder $message
	 * @param mixed[] $meta
	 * @return MailBuilder
	 */
	public function processMessage(MailBuilder $message, $meta)
	{
		$message->setSubject($meta['subject']);
		return $message;
	}

}
