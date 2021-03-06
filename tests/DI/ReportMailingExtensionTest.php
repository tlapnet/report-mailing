<?php declare(strict_types = 1);

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
use Tlapnet\ReportMailing\DI\ReportMailingExtension;
use Tlapnet\ReportMailing\Processor\ProcessorResolver;
use Tlapnet\ReportMailing\ReportSender;

final class ReportMailingExtensionTest extends TestCase
{

	public function testRegister(): void
	{
		$loader = new ContainerLoader(__DIR__ . '/../temp', true);
		$class = $loader->load(function (Compiler $compiler): void {
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
			// ReportMailing
			$compiler->addExtension('reportMailing', new ReportMailingExtension());
		});
		/** @var Container $container */
		$container = new $class();
		self::assertInstanceOf(ReportSender::class, $container->getByType(ReportSender::class));
		self::assertInstanceOf(ProcessorResolver::class, $container->getByType(ProcessorResolver::class));
	}

}
