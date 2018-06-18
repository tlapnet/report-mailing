<?php declare(strict_types = 1);

namespace Tlapnet\ReportMailing;

class MailConfig
{

	/** @var string[] */
	private $to = [];

	/** @var string */
	private $subject;

	/** @var string */
	private $templateFile;

	/** @var mixed[] */
	private $templateParams = [];

	/**
	 * @param mixed[] $config
	 */
	public function __construct(array $config)
	{
		// string or array
		$to = $config['to'] ?? [];
		if (is_string($to)) {
			$to = [$to];
		}
		$this->to = $to;
		$this->subject = $config['subject'] ?? '';
		$this->templateFile = $config['template']['file'] ?? '';
		$this->templateParams = $config['template']['params'] ?? [];
	}

	/**
	 * @return string[]
	 */
	public function getTo(): array
	{
		return $this->to;
	}

	/**
	 * @param string[] $to
	 */
	public function setTo(array $to): void
	{
		$this->to = $to;
	}

	public function getSubject(): string
	{
		return $this->subject;
	}

	public function setSubject(string $subject): void
	{
		$this->subject = $subject;
	}

	public function getTemplateFile(): string
	{
		return $this->templateFile;
	}

	public function setTemplateFile(string $templateFile): void
	{
		$this->templateFile = $templateFile;
	}

	/**
	 * @return mixed[]
	 */
	public function getTemplateParams(): array
	{
		return $this->templateParams;
	}

	/**
	 * @param mixed[] $templateParams
	 */
	public function setTemplateParams(array $templateParams): void
	{
		$this->templateParams = $templateParams;
	}

}
