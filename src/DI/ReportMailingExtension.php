<?php

namespace Tlapnet\ReportMailing\DI;

use Contributte\Mailing\DI\MailingExtension;
use Contributte\Scheduler\DI\SchedulerExtension;
use Contributte\Scheduler\IScheduler;
use Nette\DI\CompilerExtension;
use Nette\DI\Statement;
use Tlapnet\ReportMailing\Exceptions\Logic\InvalidStateException;
use Tlapnet\ReportMailing\Feed;
use Tlapnet\ReportMailing\JobContainer;
use Tlapnet\ReportMailing\MailConfig;
use Tlapnet\ReportMailing\Processor\FromProcessor;
use Tlapnet\ReportMailing\Processor\ProcessorConfig;
use Tlapnet\ReportMailing\Processor\ProcessorResolver;
use Tlapnet\ReportMailing\Processor\SubjectProcessor;
use Tlapnet\ReportMailing\Processor\TemplateProcessor;
use Tlapnet\ReportMailing\Processor\ToProcessor;
use Tlapnet\ReportMailing\ReportSender;
use Tlapnet\ReportMailing\ReportSenderJob;

class ReportMailingExtension extends CompilerExtension
{

	/** @var mixed[] */
	private $defaults = [
		'feeds' => [],
		'processors' => [
			'to' => ToProcessor::class,
			'from' => FromProcessor::class,
			'subject' => SubjectProcessor::class,
			'template' => TemplateProcessor::class,
		],
		'globalProcessors' => [],
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

		// Required extensions
		if (!$this->compiler->getExtensions(SchedulerExtension::class)) {
			throw new InvalidStateException(
				sprintf('You should register %s before %s.', SchedulerExtension::class, get_class($this))
			);
		}
		if (!$this->compiler->getExtensions(MailingExtension::class)) {
			throw new InvalidStateException(
				sprintf('You should register %s before %s.', SchedulerExtension::class, get_class($this))
			);
		}

		// Sender
		$builder->addDefinition($this->prefix('reportSender'))
			->setClass(ReportSender::class);

		// Processors
		$processors = [];
		foreach ($config['processors'] as $key => $processor) {
			$processors[$key] = $builder->addDefinition($this->prefix('processor.' . $key))
				->setClass($processor);
		}
		$builder->addDefinition($this->prefix('processorResolver'))
			->setClass(ProcessorResolver::class, [$processors]);

		// Job Container
		$jobContainer = $builder->addDefinition($this->prefix('jobContainer'))
			->setClass(JobContainer::class);

		// Get scheduler
		$scheduler = $builder->getDefinitionByType(IScheduler::class);

		// Global Processors
		$globalProcessorConfig = [];
		foreach ($config['globalProcessors'] as $processorConfig) {
			$globalProcessorConfig[] = new Statement(ProcessorConfig::class, [$processorConfig]);
		}

		foreach ($config['feeds'] as $key => $feedConfig) {
			// Mail
			$mailConfig = new Statement(MailConfig::class, [$feedConfig['mail']]);
			// Cron
			$cron = $feedConfig['cron'];
			// Processors
			$processorsConfig = [];
			foreach ($feedConfig['processors'] as $processorConfig) {
				$processorsConfig[] = new Statement(ProcessorConfig::class, [$processorConfig]);
			}
			// Feed
			$processorsConfig = array_merge($globalProcessorConfig, $processorsConfig);
			$feed = new Statement(Feed::class, [$mailConfig, $cron, $processorsConfig]);
			$senderJob = new Statement(ReportSenderJob::class, [$feed]);
			// Add job
			$jobContainer->addSetup('add', [$senderJob, $this->prefix($key)]);
			$scheduler->addSetup('add', [$senderJob, $this->prefix($key)]);
		}
	}

}
