<?php

namespace App\Repositories;

use App\Companies;


class CompaniesRepository
{

    protected $company;
    protected $nb_max = 100;

    public function __construct(Companies $company)
	{
		$this->company = $company;
	}

	private function save(Companies $company, Array $inputs)
	{
		$company->name = $inputs['name'];
		$company->logo = $inputs['logo'];
		$company->departments = $inputs['departments'];
	
		$company->save();
	}

	public function getPaginate($n)
	{
		return $this->company->paginate($n);
	}

	public function store(Array $inputs)
	{
		$company = new $this->company;		
		
		$response = $this->save($company, $inputs);
	}

	public function getById($id)
	{
		return $this->company->findOrFail($id);
	}

	public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}

	public function destroy($id)
	{
		$this->getById($id)->delete();
	}

	public function list_array()
	{
		$companies_array = Array(null => 'No company');

		foreach ($this->company->paginate($this->nb_max) as $company_row) {
			$comp_id = $company_row->id;
			$comp_name = $company_row->name;
			$companies_array += Array( $comp_id => $comp_name );
		}

		return $companies_array;
	}

	public function getDevice()
	{
		return $this->company->devices;
	}
}