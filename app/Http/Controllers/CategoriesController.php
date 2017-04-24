<?php

namespace App\Http\Controllers;

if(!isset($_SESSION['nbp'])){session_start();}

use Illuminate\Http\Request;

use App\Http\Requests\Categories\CategoriesCreateRequest;
use App\Http\Requests\Categories\CategoriesUpdateRequest;

use App\Repositories\CategoriesRepository;

class CategoriesController extends Controller
{
 
    protected $categoriesRepository;
    protected $nbrPerPage = 5;

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
        $nbrPerPage = $this->nbrPerPage;

        if(isset($_SESSION['nbp']))
            $nbrPerPage = $_SESSION['nbp'];
        
        $categories = $this->categoriesRepository->getPaginate($nbrPerPage);

        return view('categories', compact('categories'));
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
        $response = $this->categoriesRepository->store($request->all());

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
        $category = $this->categoriesRepository->getById($id);

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
        $this->categoriesRepository->update($id, $request->all());

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
        $this->categoriesRepository->destroy($id);

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
        $categories = $this->categoriesRepository->getPaginate(50);

        return view('categories/index', compact('categories'));
    }

    public function list_array()
    {
        $categories_array = $this->categoriesRepository->list_array();

        return $categories_array;
    }

    public function getFields($mode, $id)
    {
        $category = $this->categoriesRepository->getById($id);

        return view('categories/fields_'.$mode, compact('category'));
    }
}
