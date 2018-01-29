<?php

namespace Tlapnet\ReportMailing;

use Tlapnet\ReportMailing\Exceptions\Logic\InvalidStateException;

class ReportSender
{

	/** @var MessageBuilder */
	private $messageBuilder;

	/**
	 * @param MessageBuilder $messageBuilder
	 */
	public function __construct(MessageBuilder $messageBuilder)
	{
		$this->messageBuilder = $messageBuilder;
	}

	/**
	 * @param Feed $feed
	 * @return void
	 */
	public function send(Feed $feed)
	{
		$message = $this->messageBuilder->create($feed);

		// Validation
		if (!$message->getTemplate()->getFile()) {
			throw new InvalidStateException('Missing template file');
		}
		if (!$message->getMessage()->getHeader('To')) {
			throw new InvalidStateException('Missing to');
		}

		// Send message
		$message->send();
	}

}
