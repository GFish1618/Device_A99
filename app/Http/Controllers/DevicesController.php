<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests\Devices\DevicesCreateRequest;
use App\Http\Requests\Devices\DevicesUpdateRequest;
use App\Http\Requests\Devices\DevicesSearchRequest;
use App\Http\Requests\Devices\DevicesCategoryRequest;
use App\Http\Requests\Devices\DevicesImportRequest;

use App\Repositories\DeviceRepository;
use App\Repositories\FileRepository;

use Excel;



class DevicesController extends Controller
{
 
	protected $deviceRepository;
	protected $nbrPerPage = 5;

	public function __construct(DeviceRepository $deviceRepository)
    {
        $this->middleware('auth');
		$this->deviceRepository = $deviceRepository;
	}


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $devices = $this->deviceRepository->getPaginate($this->nbrPerPage);

		return view('index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->admin < 1) {return redirect('device')->withOk("You don't have the right to get here");}

        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DevicesCreateRequest $request)
    {
        if(auth()->user()->admin < 1) {return redirect('device')->withOk("You don't have the right to get here");}

        $device = $this->deviceRepository->store($request->all());

		return redirect('device')->withOk("The device: " . $device->device_name . " was created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $device = $this->deviceRepository->getById($id);

		return view('show',  compact('device'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->admin < 1) {return redirect('device')->withOk("You don't have the right to get here");}

        $device = $this->deviceRepository->getById($id);

		return view('edit',  compact('device'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DevicesUpdateRequest $request, $id)
    {
        if(auth()->user()->admin < 1) {return redirect('device')->withOk("You don't have the right to get here");}

        $this->deviceRepository->update($id, $request->all());
		
		return redirect('device')->withOk("The device: " . $request->input('device_name') . " was updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withOk("You are not allowed to delete");}
        $this->deviceRepository->destroy($id);

		return back();
    }

    public function reset()
    {
        echo("<pre>__
##|_          hmmm, 'press to reset'!
##| |    _  .' ...wonder if that's for real??
##| D- o')            __
##|_| \.\",         -=(o '.
##|     ||_           '.-.\
##|    .\".            /|  \\\\
##|   _|_|            '|  ||
-----------------------_\_):,_------</pre>");
        $this->deviceRepository->reset();
        return back();
    }

    public function search()
    {
        return view('search');
    }

    public function display(DevicesSearchRequest $request)
    {
        $devices = $this->deviceRepository->search($request->all(), $this->nbrPerPage, $request->all()['orderby']);

        $links = $devices->render();

        return view('index', compact('devices', 'links'));
    }

    public function category($cat)
    {
        $devices = $this->deviceRepository->search(['category' => $cat], $this->nbrPerPage);

        $links = $devices->render();

        return view('index', compact('devices', 'links'));
    }

    public function exportxls()
    {
        $this->deviceRepository->export();
    }

    public function importxls(DevicesImportRequest $request)
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withOk("You don't have the right to get here");}

        if($this->deviceRepository->verifxls($request->all()['file']))
        {

            $this->deviceRepository->import($request->all()['file']);
            return redirect('/device')->withOk("File data added");
        }
        else
        {
            return redirect('/device/import')->withOk("Incorrect file columns");
        }
        
    }

    public function addCategoryForm()
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withOk("You don't have the right to get here");}

        return view('addCategory');
    }

    public function addCategoryPost(DevicesCategoryRequest $request)
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withOk("You don't have the right to get here");}

        $test = $request->all();
        FileRepository::addCategory(strtolower($test['new_category']));
        return redirect('admin/categories')->withOk('The category '.$test['new_category'].' was added');
    }

    public function deleteCategory(DevicesCategoryRequest $request)
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withOk("You don't have the right to get here");}

        $test = $request->all();
        FileRepository::deleteCategory(strtolower($test['category']));
        return redirect('admin/categories')->withOk('The category '.$test['category'].' was deleted');
    }
}
