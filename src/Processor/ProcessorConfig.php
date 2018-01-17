<?php

namespace Tlapnet\ReportMailing\Processor;

class ProcessorConfig
{

	/** @var string */
	private $type;

	/** @var mixed[] */
	private $meta = [];

	/**
	 * @param mixed[] $config
	 */
	public function __construct(array $config)
	{
		$this->type = $config['type'];
		$this->meta = $config['meta'];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @return mixed[]
	 */
	public function getMeta()
	{
		return $this->meta;
	}

}
