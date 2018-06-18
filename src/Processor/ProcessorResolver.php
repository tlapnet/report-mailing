<?php declare(strict_types = 1);

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

	public function get(string $type): IProcessor
	{
		if (isset($this->processors[$type])) {
			return $this->processors[$type];
		}
		throw new InvalidStateException('Processor type "' . $type . '" not found');
	}

}
