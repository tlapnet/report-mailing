<?php

namespace Tests\Tlapnet\ReportMailing\Processor;

use Mockery;
use Mockery\MockInterface;
use Tests\Tlapnet\ReportMailing\MockeryTest;
use Tlapnet\ReportMailing\Feed;
use Tlapnet\ReportMailing\JobContainer;
use Tlapnet\ReportMailing\MailConfig;
use Tlapnet\ReportMailing\ReportSender;
use Tlapnet\ReportMailing\ReportSenderJob;

final class JobContainerTest extends MockeryTest
{

	/**
	 * @return void
	 */
	public function testManage()
	{
		$jobContainer = new JobContainer();

		self::assertEmpty($jobContainer->getAll());
		self::assertEmpty($jobContainer->getFeeds());

		/** @var ReportSender|MockInterface $reportSender */
		$reportSender = Mockery::mock(ReportSender::class);

		$feedA = new Feed(new MailConfig([]), '* * * * *', []);
		$feedB = new Feed(new MailConfig([]), '*/2 * * * *', []);

		$jobA = new ReportSenderJob($feedA, $reportSender);
		$jobB = new ReportSenderJob($feedB, $reportSender);

		$jobContainer->add($jobA, 'jobA');
		$jobContainer->add($jobB);

		self::assertEquals(['jobA' => $jobA, $jobB], $jobContainer->getAll());
		self::assertEquals(['jobA' => $feedA, $feedB], $jobContainer->getFeeds());

		self::assertEquals($jobA, $jobContainer->get('jobA'));
		self::assertEquals($jobB, $jobContainer->get('0'));
	}

}
