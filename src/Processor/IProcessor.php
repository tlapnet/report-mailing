<?php

namespace Tlapnet\ReportMailing\Processor;

use Contributte\Mailing\MailBuilder;

interface IProcessor
{

	/**
	 * @param MailBuilder $message
	 * @param mixed[] $meta
	 * @return MailBuilder
	 */
	public function processMessage(MailBuilder $message, $meta);

}
