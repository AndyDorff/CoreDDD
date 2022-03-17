<?php


namespace Modules\Core\Tests\Unit\Traits;


use Illuminate\Database\Connection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

trait TestConnection
{
	use DatabaseTransactions;
	/**
	 * @var Connection
	 */
	protected $connection;

	protected function connectionsToTransact(): array
	{
		return $this->initConnection();
	}

	private function initConnection(): array
	{
		if(!$this->connection){
			config(['database.connections.sqlite_testing' => [
				'driver' => 'sqlite',
				'database' => ':memory:',
				'prefix' => '',
				'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true)
			]]);
			$this->connection = DB::connection('sqlite_testing');
			$this->afterInitConnection();
		}

		return ['sqlite_testing'];
	}

	abstract protected function afterInitConnection(): void;
}
