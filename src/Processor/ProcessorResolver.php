<?php

namespace Tlapnet\ReportMailing\Processor;

use Tlapnet\ReportMailing\Exceptions\Logic\InvalidStateException;

class ProcessorResolver
{

	/** @var IProcessor[] */
	private $processors = [];

	/**
	 * @param IProcessor[] $processors
	 */
	public function __construct(array $processors)
	{
		$this->processors = $processors;
	}

	/**
	 * @param string $type
	 * @return IProcessor
	 */
	public function get($type)
	{
		if (isset($this->processors[$type])) {
			return $this->processors[$type];
		}
		throw new InvalidStateException('Processor type "' . $type . '" not found');
	}

}
