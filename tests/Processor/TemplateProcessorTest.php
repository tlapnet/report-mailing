<?php

namespace Tests\Tlapnet\ReportMailing\Processor;

use Contributte\Mailing\MailBuilder;
use Mockery;
use Mockery\MockInterface;
use Tests\Tlapnet\ReportMailing\MockeryTest;
use Tlapnet\ReportMailing\Processor\TemplateProcessor;

final class TemplateProcessorTest extends MockeryTest
{

	/**
	 * @return void
	 */
	public function testProcess()
	{
		$file = 'template.latte';
		$params = ['a' => 'b'];
		$meta = ['file' => $file, 'params' => $params];

		/** @var MailBuilder|MockInterface $mail */
		$mail = Mockery::mock(MailBuilder::class)
			->shouldReceive('setTemplateFile')
			->withArgs([$file])
			->getMock()
			->shouldReceive('setParameters')
			->withArgs([$params])
			->getMock();

		$processor = new TemplateProcessor();
		$mail = $processor->processMessage($mail, $meta);
		self::assertInstanceOf(MailBuilder::class, $mail);
	}

}
