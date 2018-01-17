<?php

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
		$this->to = isset($config['to']) ? $config['to'] : [];
		$this->subject = isset($config['subject']) ? $config['subject'] : '';
		$this->templateFile = isset($config['template']['file']) ? $config['template']['file'] : '';
		$this->templateParams = isset($config['template']['params']) ? $config['template']['params'] : [];
	}

	/**
	 * @return string[]
	 */
	public function getTo()
	{
		return $this->to;
	}

	/**
	 * @return string
	 */
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * @return string
	 */
	public function getTemplateFile()
	{
		return $this->templateFile;
	}

	/**
	 * @return mixed[]
	 */
	public function getTemplateParams()
	{
		return $this->templateParams;
	}

}
