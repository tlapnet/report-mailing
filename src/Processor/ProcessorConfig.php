<?php declare(strict_types = 1);

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

	public function getType(): string
	{
		return $this->type;
	}

	public function setType(string $type): void
	{
		$this->type = $type;
	}

	/**
	 * @return mixed[]
	 */
	public function getMeta(): array
	{
		return $this->meta;
	}

	/**
	 * @param mixed[] $meta
	 */
	public function setMeta(array $meta): void
	{
		$this->meta = $meta;
	}

}
