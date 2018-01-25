<?php

namespace Tlapnet\ReportMailing;

use Contributte\Mailing\IMailBuilderFactory;
use Tlapnet\ReportMailing\Exceptions\Logic\InvalidStateException;
use Tlapnet\ReportMailing\Processor\ProcessorResolver;

class ReportSender
{

	/** @var ProcessorResolver */
	private $processorResolver;

	/** @var IMailBuilderFactory */
	private $mailBuilderFactory;

	/**
	 * @param ProcessorResolver $processorResolver
	 * @param IMailBuilderFactory $mailBuilderFactory
	 */
	public function __construct(
		ProcessorResolver $processorResolver,
		IMailBuilderFactory $mailBuilderFactory
	)
	{
		$this->processorResolver = $processorResolver;
		$this->mailBuilderFactory = $mailBuilderFactory;
	}

	/**
	 * @param Feed $feed
	 * @return void
	 */
	public function send(Feed $feed)
	{
		// Create message
		$config = $feed->getMailConfig();
		$message = $this->mailBuilderFactory->create();
		foreach ($config->getTo() as $to) {
			$message->addTo($to);
		}
		$message->setSubject($config->getSubject());
		$message->setTemplateFile($config->getTemplateFile());
		$message->setParameters($config->getTemplateParams());

		foreach ($feed->getProcessors() as $processorConfig) {
			$processor = $this->processorResolver->get($processorConfig->getType());
			$message = $processor->processMessage($message, $processorConfig->getMeta());
		}

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
