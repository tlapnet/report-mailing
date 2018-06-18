<?php declare(strict_types = 1);

namespace Tlapnet\ReportMailing;

use Tlapnet\ReportMailing\Processor\ProcessorConfig;

class Feed
{

	/** @var string */
	private $expression;

	/** @var MailConfig */
	private $mailConfig;

	/** @var ProcessorConfig[] */
	private $processors = [];

	/**
	 * @param ProcessorConfig[] $processors
	 */
	public function __construct(MailConfig $mailConfig, string $expression, array $processors)
	{
		$this->expression = $expression;
		$this->mailConfig = $mailConfig;
		$this->processors = $processors;
	}

	public function getExpression(): string
	{
		return $this->expression;
	}

	public function getMailConfig(): MailConfig
	{
		return $this->mailConfig;
	}

	/**
	 * @return ProcessorConfig[]
	 */
	public function getProcessors(): array
	{
		return $this->processors;
	}

}
