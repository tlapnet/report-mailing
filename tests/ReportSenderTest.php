<?php

namespace Tests\Tlapnet\ReportMailing;

use Contributte\Mailing\IMailBuilderFactory;
use Contributte\Mailing\MailBuilder;
use Mockery;
use Mockery\MockInterface;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Mail\Message;
use Tlapnet\ReportMailing\Feed;
use Tlapnet\ReportMailing\MailConfig;
use Tlapnet\ReportMailing\Processor\IProcessor;
use Tlapnet\ReportMailing\Processor\ProcessorConfig;
use Tlapnet\ReportMailing\Processor\ProcessorResolver;
use Tlapnet\ReportMailing\ReportSender;

final class ReportSenderTest extends MockeryTest
{

	/**
	 * @return void
	 */
	public function testSend()
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

		/** @var ProcessorResolver|MockInterface $processorResolver */
		$processorResolver = Mockery::mock(ProcessorResolver::class);

		/** @var MailBuilder|MockInterface $message */
		$message = Mockery::mock(MailBuilder::class)
			->shouldReceive('send')
			->once()
			->getMock()
			->shouldReceive('setSubject')
			->withArgs([''])
			->once()
			->getMock()
			->shouldReceive('setTemplateFile')
			->withArgs([$file])
			->once()
			->getMock()
			->shouldReceive('getTemplate')
			->andReturn($template)
			->once()
			->getMock()
			->shouldReceive('getMessage')
			->andReturn($message)
			->once()
			->getMock()
			->shouldReceive('addTo')
			->withArgs(['mail@example.com'])
			->once()
			->getMock()
			->shouldReceive('setParameters')
			->withArgs([[]])
			->once()
			->getMock();

		/** @var IMailBuilderFactory|MockInterface $mailBuilderFactory */
		$mailBuilderFactory = Mockery::mock(IMailBuilderFactory::class)
			->shouldReceive('create')
			->once()
			->andReturn($message)
			->getMock();

		$mailConfig = new MailConfig(['to' => 'mail@example.com', 'template' => ['file' => $file]]);
		$feed = new Feed($mailConfig, '* * * * *', []);

		$mailer = new ReportSender($processorResolver, $mailBuilderFactory);
		$mailer->send($feed);
	}

	/**
	 * @depends testSend
	 * @return void
	 */
	public function testSendConfig()
	{
		$subject = 's';
		$to = 'mail@example.com';
		$file = 'template.latte';
		$params = ['a', 'b', 'c'];

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

		/** @var ProcessorResolver|MockInterface $processorResolver */
		$processorResolver = Mockery::mock(ProcessorResolver::class);

		/** @var MailBuilder|MockInterface $message */
		$message = Mockery::mock(MailBuilder::class)
			->shouldReceive('send')
			->once()
			->getMock()
			->shouldReceive('setSubject')
			->withArgs([$subject])
			->once()
			->getMock()
			->shouldReceive('addTo')
			->withArgs([$to])
			->once()
			->getMock()
			->shouldReceive('setTemplateFile')
			->withArgs([$file])
			->once()
			->getMock()
			->shouldReceive('setParameters')
			->withArgs([$params])
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

		/** @var IMailBuilderFactory|MockInterface $mailBuilderFactory */
		$mailBuilderFactory = Mockery::mock(IMailBuilderFactory::class)
			->shouldReceive('create')
			->once()
			->andReturn($message)
			->getMock();

		$config = new MailConfig([
			'subject' => $subject,
			'to' => [
				$to,
			],
			'template' => [
				'file' => $file,
				'params' => $params,
			],
		]);

		$feed = new Feed($config, '* * * * *', []);

		$mailer = new ReportSender($processorResolver, $mailBuilderFactory);
		$mailer->send($feed);
	}

	/**
	 * @depends testSend
	 * @return void
	 */
	public function testSendProcessor()
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

		$type = 'report';
		$meta = [
			'keys' => ['report-a', 'report-b'],
		];

		/** @var MailBuilder|MockInterface $message */
		$message = Mockery::mock(MailBuilder::class)
			->shouldReceive('send')
			->once()
			->getMock()
			->shouldReceive('setSubject')
			->withArgs([''])
			->once()
			->getMock()
			->shouldReceive('setTemplateFile')
			->withArgs([''])
			->once()
			->getMock()
			->shouldReceive('setParameters')
			->withArgs([[]])
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

		/** @var IProcessor|MockInterface $processor */
		$processor = Mockery::mock(IProcessor::class)
			->shouldReceive('processMessage')
			->withArgs([$message, $meta])
			->andReturn($message)
			->once()
			->getMock();

		/** @var ProcessorResolver|MockInterface $processorResolver */
		$processorResolver = Mockery::mock(ProcessorResolver::class)
			->shouldReceive('get')
			->withArgs([$type])
			->once()
			->andReturn($processor)
			->getMock();

		/** @var IMailBuilderFactory|MockInterface $mailBuilderFactory */
		$mailBuilderFactory = Mockery::mock(IMailBuilderFactory::class)
			->shouldReceive('create')
			->once()
			->andReturn($message)
			->getMock();

		$feed = new Feed(new MailConfig([]), '* * * * *', [
			new ProcessorConfig([
				'type' => $type,
				'meta' => $meta,
			]),
		]);

		$mailer = new ReportSender($processorResolver, $mailBuilderFactory);
		$mailer->send($feed);
	}

}
