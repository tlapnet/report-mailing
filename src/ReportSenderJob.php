<?php

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

	/**
	 * @param Feed $feed
	 * @param ReportSender $reportSender
	 */
	public function __construct(Feed $feed, ReportSender $reportSender)
	{
		$this->reportSender = $reportSender;
		$this->feed = $feed;
	}

	/**
	 * @param DateTime $dateTime
	 * @return bool
	 */
	public function isDue(DateTime $dateTime)
	{
		$expression = CronExpression::factory($this->feed->getExpression());
		return $expression->isDue($dateTime);
	}

	/**
	 * @return void
	 */
	public function run()
	{
		$this->reportSender->send($this->feed);
	}

	/**
	 * @return Feed
	 */
	public function getFeed()
	{
		return $this->feed;
	}

}
