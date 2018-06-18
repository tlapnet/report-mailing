<?php declare(strict_types = 1);

namespace Tlapnet\ReportMailing;

use Contributte\Scheduler\IJob;
use Cron\CronExpression;
use DateTime;

class ReportSenderJob implements IJob
{

	/** @var Feed */
	private $feed;

	/** @var ReportSender */
	private $reportSender;

	public function __construct(Feed $feed, ReportSender $reportSender)
	{
		$this->reportSender = $reportSender;
		$this->feed = $feed;
	}

	public function isDue(DateTime $dateTime): bool
	{
		$expression = CronExpression::factory($this->feed->getExpression());
		return $expression->isDue($dateTime);
	}

	public function run(): void
	{
		$this->reportSender->send($this->feed);
	}

	public function getFeed(): Feed
	{
		return $this->feed;
	}

}
