<?php declare(strict_types = 1);

namespace Tlapnet\ReportMailing;

class JobContainer
{

	/** @var ReportSenderJob[] */
	private $jobs = [];

	public function add(ReportSenderJob $job, ?string $key = null): void
	{
		if ($key !== null) {
			$this->jobs[$key] = $job;
			return;
		}
		$this->jobs[] = $job;
	}

	public function get(string $key): ?ReportSenderJob
	{
		return $this->jobs[$key] ?? null;
	}

	/**
	 * @return ReportSenderJob[]
	 */
	public function getAll(): array
	{
		return $this->jobs;
	}

	/**
	 * @return Feed[]
	 */
	public function getFeeds(): array
	{
		$feeds = [];
		$jobs = $this->getAll();
		foreach ($jobs as $key => $job) {
			$feeds[$key] = $job->getFeed();
		}
		return $feeds;
	}

}
