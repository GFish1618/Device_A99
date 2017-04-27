<?php

namespace App\Http\Controllers;

if(!isset($_SESSION['nbp'])){session_start();}

use Illuminate\Http\Request;

use App\Repositories\CompaniesRepository;

class CompaniesController extends Controller
{
    protected $companiesRepository;

    public function __construct(CompaniesRepository $companiesRepository)
    {
        $this->middleware('auth');
        $this->companiesRepository = $companiesRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesCreateRequest $request)
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withError("You don't have the right to get here");}

        $response = $this->companiesRepository->store($request->all());

        return response()->json();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withError("You don't have the right to get here");}

        $category = $this->companiesRepository->getById($id);

        return view('categories/edit',  compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesUpdateRequest $request, $id)
    {   
        if(auth()->user()->admin < 2) {return redirect('device')->withError("You don't have the right to get here");}

        $this->companiesRepository->update($id, $request->all());

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withError("You don't have the right to get here");}
        
        $this->companiesRepository->destroy($id);

        return back()->withError("The category was deleted");

        /*if($this->categoriesRepository->getById($id)->devices == null)
        {
            //$this->categoriesRepository->destroy($id);
            return back()->withError("The category was deleted");
        }
        return redirect('categories')->withError("The category is connected to devices, you can only delete category with no child");*/
        
    }

    public function list_sidebar()
    {
        $companies = $this->list_array();

        //echo('<pre>');
        //print_r($companies);

        return view('companies/index', compact('companies'));
    }

    public function list_array()
    {
    	$companies = $this->companiesRepository->getPaginate(50);

    	$companies_array = Array();

    	foreach ($companies as $company) {

	    	$departments_array = Array();
	    	$department = '';

	    	$chars = str_split($company->departments);
			foreach($chars as $char){
			    if($char != '|')
			    {
			    	$department .= $char;
			    }
			    else
			    {
			    	$departments_array += Array( $department => $department );
			    	$department = '';
			    }
			}
			$companies_array += Array(
				$company->name => Array(
					'id' => $company->id,
					'name' => $company->name,
					'logo' => $company->logo,
					'departments' => $departments_array
				)
			);
    	}

    	return $companies_array;
    
    }

}
