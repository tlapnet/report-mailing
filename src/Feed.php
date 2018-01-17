<?php

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
	 * @param MailConfig $mailConfig
	 * @param string $expression
	 * @param ProcessorConfig[] $processors
	 */
	public function __construct(MailConfig $mailConfig, $expression, $processors)
	{
		$this->expression = $expression;
		$this->mailConfig = $mailConfig;
		$this->processors = $processors;
	}

	/**
	 * @return string
	 */
	public function getExpression()
	{
		return $this->expression;
	}

	/**
	 * @return MailConfig
	 */
	public function getMailConfig()
	{
		return $this->mailConfig;
	}

	/**
	 * @return ProcessorConfig[]
	 */
	public function getProcessors()
	{
		return $this->processors;
	}

}
