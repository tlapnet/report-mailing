<?php declare(strict_types = 1);

namespace Tlapnet\ReportMailing\Processor;

use Contributte\Mailing\MailBuilder;

interface IProcessor
{

	/**
	 * @param mixed[] $meta
	 */
	public function processMessage(MailBuilder $message, array $meta): MailBuilder;

}
