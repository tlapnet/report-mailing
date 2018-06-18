<?php declare(strict_types = 1);

namespace Tests\Tlapnet\ReportMailing;

use Contributte\Mailing\IMailBuilderFactory;
use Contributte\Mailing\MailBuilder;
use Mockery;
use Mockery\MockInterface;
use Tlapnet\ReportMailing\Feed;
use Tlapnet\ReportMailing\MailConfig;
use Tlapnet\ReportMailing\MessageBuilder;
use Tlapnet\ReportMailing\Processor\IProcessor;
use Tlapnet\ReportMailing\Processor\ProcessorConfig;
use Tlapnet\ReportMailing\Processor\ProcessorResolver;

final class MessageBuilderTest extends MockeryTest
{

	public function testCreate(): void
	{
		$file = 'template.latte';

		/** @var ProcessorResolver|MockInterface $processorResolver */
		$processorResolver = Mockery::mock(ProcessorResolver::class);

		/** @var MailBuilder|MockInterface $message */
		$message = Mockery::mock(MailBuilder::class)
			->shouldReceive('setSubject')
			->withArgs([''])
			->once()
			->getMock()
			->shouldReceive('addTo')
			->withArgs(['mail@example.com'])
			->once()
			->getMock()
			->shouldReceive('setTemplateFile')
			->withArgs([$file])
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

		$messageBuilder = new MessageBuilder($processorResolver, $mailBuilderFactory);
		$messageBuilder->create($feed);
	}

	/**
	 * Depends
	 *
	 * @depends testCreate
	 */
	public function testCreateConfig(): void
	{
		$subject = 's';
		$to = 'mail@example.com';
		$file = 'template.latte';
		$params = ['a', 'b', 'c'];

		/** @var ProcessorResolver|MockInterface $processorResolver */
		$processorResolver = Mockery::mock(ProcessorResolver::class);

		/** @var MailBuilder|MockInterface $message */
		$message = Mockery::mock(MailBuilder::class)
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

		$messageBuilder = new MessageBuilder($processorResolver, $mailBuilderFactory);
		$messageBuilder->create($feed);
	}

	/**
	 * Depends
	 *
	 * @depends testCreate
	 */
	public function testCreateProcessor(): void
	{
		$type = 'report';
		$meta = [
			'keys' => ['report-a', 'report-b'],
		];

		/** @var MailBuilder|MockInterface $message */
		$message = Mockery::mock(MailBuilder::class)
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

		$messageBuilder = new MessageBuilder($processorResolver, $mailBuilderFactory);
		$messageBuilder->create($feed);
	}

}
