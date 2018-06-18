<?php declare(strict_types = 1);

namespace Tests\Tlapnet\ReportMailing;

use Contributte\Mailing\MailBuilder;
use Mockery;
use Mockery\MockInterface;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Mail\Message;
use Tlapnet\ReportMailing\Feed;
use Tlapnet\ReportMailing\MailConfig;
use Tlapnet\ReportMailing\MessageBuilder;
use Tlapnet\ReportMailing\ReportSender;

final class ReportSenderTest extends MockeryTest
{

	public function testSend(): void
	{
		$file = 'report.latte';

		/** @var Template|MockInterface $template */
		$template = Mockery::mock(Template::class)
			->shouldReceive('getFile')
			->andReturn($file)
			->getMock();

		/** @var Message|MockInterface $message */
		$message = Mockery::mock(Message::class)
			->shouldReceive('getHeader')
			->withArgs(['To'])
			->andReturn('...')
			->getMock();

		/** @var MailBuilder|MockInterface $message */
		$message = Mockery::mock(MailBuilder::class)
			->shouldReceive('send')
			->once()
			->getMock()
			->shouldReceive('getTemplate')
			->andReturn($template)
			->once()
			->getMock()
			->shouldReceive('getMessage')
			->andReturn($message)
			->once()
			->getMock();

		$mailConfig = new MailConfig(['to' => 'mail@example.com', 'template' => ['file' => $file]]);
		$feed = new Feed($mailConfig, '* * * * *', []);

		/** @var MessageBuilder|MockInterface $messageBuilder */
		$messageBuilder = Mockery::mock(MessageBuilder::class)
			->shouldReceive('create')
			->once()
			->andReturn($message)
			->getMock();

		$mailer = new ReportSender($messageBuilder);
		$mailer->send($feed);
	}

}
