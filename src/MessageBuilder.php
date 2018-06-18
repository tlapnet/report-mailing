<?php declare(strict_types = 1);

namespace Tlapnet\ReportMailing;

use Contributte\Mailing\IMailBuilderFactory;
use Contributte\Mailing\MailBuilder;
use Tlapnet\ReportMailing\Processor\ProcessorResolver;

class MessageBuilder
{

	/** @var ProcessorResolver */
	private $processorResolver;

	/** @var IMailBuilderFactory */
	private $mailBuilderFactory;

	public function __construct(
		ProcessorResolver $processorResolver,
		IMailBuilderFactory $mailBuilderFactory
	)
	{
		$this->processorResolver = $processorResolver;
		$this->mailBuilderFactory = $mailBuilderFactory;
	}

	public function create(Feed $feed): MailBuilder
	{
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

		return $message;
	}

}
