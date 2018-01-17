<?php

namespace Tlapnet\ReportMailing\DI;

use Contributte\Scheduler\IScheduler;
use Nette\DI\CompilerExtension;
use Nette\DI\Statement;
use Tlapnet\ReportMailing\Feed;
use Tlapnet\ReportMailing\MailConfig;
use Tlapnet\ReportMailing\Processor\ProcessorConfig;
use Tlapnet\ReportMailing\Processor\ProcessorResolver;
use Tlapnet\ReportMailing\ReportSender;
use Tlapnet\ReportMailing\ReportSenderJob;

class ReportMailingExtension extends CompilerExtension
{

	/** @var mixed[] */
	private $defaults = [
		'feeds' => [],
		'processors' => [],
	];

	/**
	 * Register services
	 *
	 * @return void
	 */
	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig($this->defaults);

		// Register services
		$builder->addDefinition($this->prefix('reportMailer'))
			->setClass(ReportSender::class);
		$processors = [];
		foreach ($config['processors'] as $key => $processor) {
			$processors[$key] = $builder->addDefinition($this->prefix('processor.' . $key))
				->setClass($processor);
		}
		$builder->addDefinition($this->prefix('processorResolver'))
			->setClass(ProcessorResolver::class, [$processors]);

		// Get scheduler
		$scheduler = $builder->getDefinitionByType(IScheduler::class);

		//todo exception

		foreach ($config['feeds'] as $key => $feedConfig) {
			//Mail
			$mailConfig = new Statement(MailConfig::class, [$feedConfig['mail']]);
			//Cron
			$cron = $feedConfig['cron'];
			//Processors
			$processorsConfig = [];
			foreach ($feedConfig['processors'] as $processorConfig) {
				$processorsConfig[] = new Statement(ProcessorConfig::class, [$processorConfig]);
			}
			//Feed
			$feed = new Statement(Feed::class, [$mailConfig, $cron, $processors]);
			$senderJob = new Statement(ReportSenderJob::class, [$feed]);
			// Add job
			$scheduler->addSetup('add', [$senderJob, 'reportMailing.' . $key]);
		}
	}

}
