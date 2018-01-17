<?php

namespace Tests\Tlapnet\ReportMailing\DI;

use Contributte\Mailing\DI\MailingExtension;
use Contributte\Scheduler\DI\SchedulerExtension;
use Nette\Bridges\ApplicationDI\ApplicationExtension;
use Nette\Bridges\ApplicationDI\LatteExtension;
use Nette\Bridges\ApplicationDI\RoutingExtension;
use Nette\Bridges\HttpDI\HttpExtension;
use Nette\Bridges\MailDI\MailExtension;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use PHPUnit\Framework\TestCase;
use Tlapnet\Report\Bridges\Nette\DI\ReportExtension;
use Tlapnet\ReportMailing\DI\ReportMailingExtension;
use Tlapnet\ReportMailing\Processor\ProcessorResolver;
use Tlapnet\ReportMailing\ReportSender;

final class ReportMailingExtensionTest extends TestCase
{

	/**
	 * @return void
	 */
	public function testRegister()
	{
		$loader = new ContainerLoader(__DIR__ . '/temp', TRUE);
		$class = $loader->load(function (Compiler $compiler) {
			// Contributte Mailing
			$compiler->addExtension('latte', new LatteExtension(''));
			$compiler->addExtension('http', new HttpExtension());
			$compiler->addExtension('routing', new RoutingExtension());
			$compiler->addExtension('app', new ApplicationExtension());
			$compiler->addExtension('mail', new MailExtension());
			$compiler->addExtension('mailing', new MailingExtension());
			// Contributte Scheduler
			$compiler->addConfig([
				'parameters' => [
					'tempDir' => '',
				],
			]);
			$compiler->addExtension('scheduler', new SchedulerExtension());
			// Report
			$compiler->addExtension('report', new ReportExtension());
			// ReportMailing
			$compiler->addExtension('reportMailing', new ReportMailingExtension());
		});
		/** @var Container $container */
		$container = new $class;
		self::assertInstanceOf(ReportSender::class, $container->getByType(ReportSender::class));
		self::assertInstanceOf(ProcessorResolver::class, $container->getByType(ProcessorResolver::class));
	}

}
