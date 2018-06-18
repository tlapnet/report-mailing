<?php declare(strict_types = 1);

namespace Tests\Tlapnet\ReportMailing\Processor;

use Contributte\Mailing\MailBuilder;
use Mockery;
use Mockery\MockInterface;
use Tests\Tlapnet\ReportMailing\MockeryTest;
use Tlapnet\ReportMailing\Processor\ToProcessor;

final class ToProcessorTest extends MockeryTest
{

	public function testProcess(): void
	{
		$email = 'mail@example.com';
		$meta = ['to' => [$email]];

		/** @var MailBuilder|MockInterface $mail */
		$mail = Mockery::mock(MailBuilder::class)
			->shouldReceive('addTo')
			->withArgs([$email])
			->getMock();

		$processor = new ToProcessor();
		$mail = $processor->processMessage($mail, $meta);
		self::assertInstanceOf(MailBuilder::class, $mail);
	}

}
