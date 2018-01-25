<?php

namespace Tlapnet\ReportMailing;

class JobContainer
{

	/** @var ReportSenderJob[] */
	private $jobs = [];

	/**
	 * @param ReportSenderJob $job
	 * @param string|NULL $key
	 * @return void
	 */
	public function add(ReportSenderJob $job, $key = NULL)
	{
		if ($key !== NULL) {
			$this->jobs[$key] = $job;
			return;
		}
		$this->jobs[] = $job;
	}

	/**
	 * @param string $key
	 * @return ReportSenderJob|NULL
	 */
	public function get($key)
	{
		return isset($this->jobs[$key]) ? $this->jobs[$key] : NULL;
	}

	/**
	 * @return ReportSenderJob[]
	 */
	public function getAll()
	{
		return $this->jobs;
	}

	/**
	 * @return Feed[]
	 */
	public function getFeeds()
	{
		$feeds = [];
		$jobs = $this->getAll();
		foreach ($jobs as $key => $job) {
			$feeds[$key] = $job->getFeed();
		}
		return $feeds;
	}

}
