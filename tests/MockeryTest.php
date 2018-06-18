<?php declare(strict_types = 1);

namespace Tests\Tlapnet\ReportMailing;

use Mockery;
use PHPUnit\Framework\TestCase;

abstract class MockeryTest extends TestCase
{

	protected function tearDown(): void
	{
		Mockery::close();
	}

}
