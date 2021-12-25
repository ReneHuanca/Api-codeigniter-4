<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
	public function run()
	{
		$data = [
			'name'  => 'rene',
			'email' => 'rene@gmail.com'
		];

		// 1 Simple Queries
		$this->db->query("INSERT INTO users (name, email) VALUES(:name:, :email:)", $data);

		// 2 Using Query Builder
		$this->db->table('users')->insert($data);

		// 3 Whit Models and Fakers
		$model = model('UserModel');

		$model->insert([
				'name'  => static::faker()->name,
				'email' => static::faker()->email,
		]);
	}
}
