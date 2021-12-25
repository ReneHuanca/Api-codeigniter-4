<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimestampsToUsers extends Migration
{
	public function up()
	{
		$fields = [
			'created_at' => ['type' => 'DATETIME'],
			'updated_at' => ['type' => 'DATETIME'],
			'deleted_at' => ['type' => 'DATETIME'],
		];
		$this->forge->addColumn('users', $fields);
	}

	public function down()
	{
		$this->forge->dropColumn('users',  ['created_at', 'updated_at', 'deleted_at']);
	}
}
