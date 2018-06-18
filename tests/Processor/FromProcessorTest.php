<?php declare(strict_types = 1);

namespace Tests\Tlapnet\ReportMailing\Processor;

use Contributte\Mailing\MailBuilder;
use Mockery;
use Mockery\MockInterface;
use Tests\Tlapnet\ReportMailing\MockeryTest;
use Tlapnet\ReportMailing\Processor\FromProcessor;

final class FromProcessorTest extends MockeryTest
{

	public function testProcess(): void
	{
		$email = 'mail@example.com';
		$name = 'John Doe';
		$meta = ['mail' => $email, 'name' => $name];

		/** @var MailBuilder|MockInterface $mail */
		$mail = Mockery::mock(MailBuilder::class)
			->shouldReceive('setFrom')
			->withArgs([$email, $name])
			->getMock();

		$processor = new FromProcessor();
		$mail = $processor->processMessage($mail, $meta);
		self::assertInstanceOf(MailBuilder::class, $mail);
	}

}
