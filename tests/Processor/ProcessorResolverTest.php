<?php

namespace Tests\Tlapnet\ReportMailing\Processor;

use Mockery;
use Mockery\MockInterface;
use Tests\Tlapnet\ReportMailing\MockeryTest;
use Tlapnet\ReportMailing\Processor\IProcessor;
use Tlapnet\ReportMailing\Processor\ProcessorResolver;

final class ProcessorResolverTest extends MockeryTest
{

	/**
	 * @return void
	 */
	public function testGet()
	{
		$type = 'report';
		/** @var IProcessor|MockInterface $processor */
		$processor = Mockery::mock(IProcessor::class);

		$resolver = new ProcessorResolver([$type => $processor]);
		self::assertSame($processor, $resolver->get($type));
	}

}