<?php

namespace App\Repositories;

use App\User;


class UsersRepository
{

    protected $user;

    public function __construct(User $user)
	{
		$this->user = $user;
	}

	private function save(User $user, Array $inputs)
	{
		$user->name = $inputs['name'];
		$user->admin = isset($inputs['admin']);
	
		$user->save();
	}

	public function getPaginate($n)
	{
		return $this->user->paginate($n);
	}

	public function store()
	{

	}

	public function getById($id)
	{
		return $this->user->findOrFail($id);
	}

	public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}

	public function destroy($id)
	{
		$this->getById($id)->socialProviders()->delete();
		$this->getById($id)->delete();
	}

	public function search(Array $inputs, $n)
	{
		$user = new $this->user;
		if (isset($inputs['name']) and $inputs['name']!=''){
			$user = $user->where('name', $inputs['name']);
		}
		if (isset($inputs['email']) and $inputs['email']!=''){
			$user = $user->where('email', $inputs['email']);
		}
		return $user->paginate($n);
	}
}