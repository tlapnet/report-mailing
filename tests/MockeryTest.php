<?php

namespace Tests\Tlapnet\ReportMailing;

use Mockery;
use PHPUnit\Framework\TestCase;

abstract class MockeryTest extends TestCase
{

	/**
	 * @return void
	 */
	protected function tearDown()
	{
		Mockery::close();
	}

}
