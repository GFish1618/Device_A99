<?php

namespace App\Http\Controllers;

if(!isset($_SESSION['nbp'])){session_start();}

use Illuminate\Http\Request;

use App\Repositories\CompaniesRepository;

class CompaniesController extends Controller
{
    protected $companiesRepository;

    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->middleware('auth');
        $this->categoriesRepository = $categoriesRepository;
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
        $categories = $this->companiesRepository->getPaginate(50);

        return view('categories/index', compact('categories'));
    }

    public function list_array()
    {
        $categories_array = $this->companiesRepository->list_array();

        return $categories_array;
    }

    public function list_departments($id)
    {
    	$departments_string = $this->companiesRepository->getById($id)->departments;

    	$departments_array = Array();

    	$department = '';

    	$chars = str_split($departments_string);
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
    }

}
