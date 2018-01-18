<?php

namespace Tests\Tlapnet\ReportMailing;

use Mockery;
use Mockery\MockInterface;
use Tlapnet\ReportMailing\Feed;
use Tlapnet\ReportMailing\MailConfig;
use Tlapnet\ReportMailing\ReportSender;
use Tlapnet\ReportMailing\ReportSenderJob;

final class ReportSenderJobTest extends MockeryTest
{

	/**
	 * @return void
	 */
	public function testRun()
	{
		$feed = new Feed(new MailConfig([]), '* * * * *', []);

		/** @var ReportSender|MockInterface $reportSender */
		$reportSender = Mockery::mock(ReportSender::class)
			->shouldReceive('send')
			->withArgs([$feed])
			->once()
			->getMock();

		$job = new ReportSenderJob($feed, $reportSender);
		$job->run();
	}

}
