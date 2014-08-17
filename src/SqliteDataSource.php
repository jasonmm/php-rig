<?php
namespace Jasonmm\Rig;


class PDODataSource implements RigDataSource {
	private $dsn = '';
	private $pdo = null;

	public function __construct($dsn) {
		$this->dsn = $dsn;
	}

	private function openDatabase() {
		if( $this->pdo instanceof \PDO ) {
			return;
		}

		$this->pdo = new \PDO($this->dsn);
	}

	public function getFemaleName() {
		$this->openDatabase();
	}
}
