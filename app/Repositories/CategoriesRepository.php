<?php

namespace App\Repositories;

use App\Categories;


class CategoriesRepository
{

    protected $category;
    protected $nb_max = 100;

    public function __construct(Categories $category)
	{
		$this->category = $category;
	}

	private function save(Categories $category, Array $inputs)
	{
		$category->category_name = $inputs['category_name'];
		$category->parents = $inputs['parents'];
		$category->number_of_fields = $inputs['number_of_fields'];

		for($i = 1; $i <= $inputs['number_of_fields']; $i++)
    	{
    		$field = 'field'.$i.'_name';
    		if (isset($inputs[$field]))
				$category->$field = $inputs[$field];
    	}
	
		$category->save();
	}

	public function getPaginate($n)
	{
		return $this->category->paginate($n);
	}

	public function store(Array $inputs)
	{
		$category = new $this->category;		
		
		$response = $this->save($category, $inputs);
	}

	public function getById($id)
	{
		return $this->category->findOrFail($id);
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
		$categories_array = Array(null => 'No category');

		foreach ($this->category->paginate($this->nb_max) as $category_row) {
			$cat_id = $category_row->id;
			$cat_name = $category_row->category_name;
			$categories_array += Array( $cat_id => $cat_name );
		}

		return $categories_array;
	}

	public function getDevice()
	{
		return $this->category->devices;
	}
}