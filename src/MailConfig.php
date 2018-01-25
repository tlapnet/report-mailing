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
	 * @param string[] $to
	 * @return void
	 */
	public function setTo($to)
	{
		$this->to = $to;
	}

	/**
	 * @return string
	 */
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * @param string $subject
	 * @return void
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;
	}

	/**
	 * @return string
	 */
	public function getTemplateFile()
	{
		return $this->templateFile;
	}

	/**
	 * @param string $templateFile
	 * @return void
	 */
	public function setTemplateFile($templateFile)
	{
		$this->templateFile = $templateFile;
	}

	/**
	 * @return mixed[]
	 */
	public function getTemplateParams()
	{
		return $this->templateParams;
	}

	/**
	 * @param mixed[] $templateParams
	 * @return void
	 */
	public function setTemplateParams($templateParams)
	{
		$this->templateParams = $templateParams;
	}

}
