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
		$company->company_name = $inputs['company_name'];
		$company->parents = $inputs['parents'];
		$company->number_of_fields = $inputs['number_of_fields'];

		for($i = 1; $i <= $inputs['number_of_fields']; $i++)
    	{
    		$field = 'field'.$i.'_name';
    		if (isset($inputs[$field]))
				$company->$field = $inputs[$field];
    	}
	
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
			$cat_id = $company_row->id;
			$cat_name = $company_row->company_name;
			$companies_array += Array( $cat_id => $cat_name );
		}

		return $companies_array;
	}

	public function getDevice()
	{
		return $this->company->devices;
	}
}