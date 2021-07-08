<?php
namespace Oness\Sincontrol\Tests;

use Oness\Sincontrol\CodigoControlServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    public function setUp(): void
    {
      parent::setUp();
      // additional setup
    }
  
    protected function getPackageProviders($app)
    {
      return [
        CodigoControlServiceProvider::class,
      ];
    }
  
    protected function getEnvironmentSetUp($app)
    {
      // perform environment setup
    }
}    