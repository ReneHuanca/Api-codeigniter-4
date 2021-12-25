<?php

namespace App\Controllers\Api;

use App\Entities\User;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class UserController extends ResourceController
{
	public function index()
	{
		$userModel = new UserModel();
		return $this->respond([
			'data'  => $userModel->paginate(3),
			'pager' => $userModel->pager,  // only in view of codeigniter
		], 200);
	}
	
	public function create()
	{
		$rules = [
			"name" => "required",
			"email" => "required|valid_email|is_unique[users.email]|min_length[6]",
		];
		if (! $this->validate($rules)) {
			return $this->respond([
				'errors' => $this->validator->getErrors(),
			], 500);
		}
		$user = new User($this->request->getPost());
		(new UserModel())->save($user);

		return $this->respondCreated([
			'message' => 'User added successfully',
			'data'    => $user
		]);
	}

	public function update($id = null)
	{
		$userModel = new UserModel();
		$user = $userModel->find($id);
		if (empty($user)) {
			return $this->respond([
				'message' => 'User not found'
			], 500);
		}
		$rules = [
			"name"  => "required",
			"email" => "required|valid_email|is_unique[users.email,id,$id]|min_length[6]",
		];
		if (! $this->validate($rules)) {
			return $this->respond([
				'errors' => $this->validator->getErrors()
			], 400);
		}
		// request->getJSON() send in json format from postman - tambien recibo post y json al mismo tiempo
		$userModel->update($id, $this->request->getJSON());
		
		return $this->respondUpdated([
			'message' => 'User updated',
			'data' => $user,
		]);
	}

	public function delete($id = null)
	{
		$userModel = new UserModel();
		$user = $userModel->find($id);
		if (empty($user)) {
			return $this->respond([
				'error' => 'User not found',
			], 500);
		}
		$userModel->delete($id);
		
		return $this->respondDeleted([
			'message' => 'User deleted',
			'data'    => $user
		]);
	}
}
