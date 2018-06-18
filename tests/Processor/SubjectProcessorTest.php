<?php declare(strict_types = 1);

namespace Tests\Tlapnet\ReportMailing\Processor;

use Contributte\Mailing\MailBuilder;
use Mockery;
use Mockery\MockInterface;
use Tests\Tlapnet\ReportMailing\MockeryTest;
use Tlapnet\ReportMailing\Processor\SubjectProcessor;

final class SubjectProcessorTest extends MockeryTest
{

	public function testProcess(): void
	{
		$subject = 'subject';
		$meta = ['subject' => $subject];

		/** @var MailBuilder|MockInterface $mail */
		$mail = Mockery::mock(MailBuilder::class)
			->shouldReceive('setSubject')
			->withArgs([$subject])
			->getMock();

		$processor = new SubjectProcessor();
		$mail = $processor->processMessage($mail, $meta);
		self::assertInstanceOf(MailBuilder::class, $mail);
	}

}
