<?php
namespace App\Http\Controllers;

session_start();

use Illuminate\Http\Request;

use App\Http\Requests\Devices\DevicesCreateRequest;
use App\Http\Requests\Devices\DevicesUpdateRequest;
use App\Http\Requests\Devices\DevicesSearchRequest;
use App\Http\Requests\Devices\DevicesCategoryRequest;
use App\Http\Requests\Devices\DevicesImportRequest;
use App\Http\Requests\Devices\DevicesIndexRequest;

use App\Repositories\DeviceRepository;
use App\Repositories\FileRepository;
use App\Repositories\GoogleAuth;

use App\Repositories\CategoriesRepository;

use Excel;
use Socialite;
use User;
use Auth;
use \Google_Client;



class DevicesController extends Controller
{
 
	protected $deviceRepository;
    protected $categoriesRepository;
	protected $nbrPerPage = 5;
    protected $orderby = 'id';

	public function __construct(DeviceRepository $deviceRepository, CategoriesRepository $categoriesRepository)
    {
        $this->middleware('auth');
		$this->deviceRepository = $deviceRepository;
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
        $orderby = $this->orderby;

        if(isset($_SESSION['nbp']))
            $nbrPerPage = $_SESSION['nbp'];
        if(isset($_SESSION['orderby']))
            $orderby = $_SESSION['orderby'];
        
        $devices = $this->deviceRepository->getPaginate($nbrPerPage, $orderby);

		return view('devices/index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->admin < 1) {return redirect('device')->withError("You don't have the right to get here");}

        $cat_array = $this->categoriesRepository->list_array();

        return view('devices/create', compact('cat_array'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DevicesCreateRequest $request)
    {
        if(auth()->user()->admin < 1) {return redirect('device')->withError("You don't have the right to get here");}

        $response = $this->deviceRepository->store($request->all());

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
        $device = $this->deviceRepository->getById($id);
        $category = $this->categoriesRepository->getById($device->category_id);

		return view('devices/show',  compact('device', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->admin < 1) {return redirect('device')->withError("You don't have the right to get here");}

        $device = $this->deviceRepository->getById($id);
        $category = $this->categoriesRepository->getById($device->category_id);

        $cat_array = $this->categoriesRepository->list_array();

		return view('devices/edit',  compact('device', 'category', 'cat_array'));
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
        if(auth()->user()->admin < 1) {return redirect('device')->withError("You don't have the right to get here");}

        $response = $this->deviceRepository->update($id, $request->all());
		
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
        if(auth()->user()->admin < 2) {return redirect('device')->withError("You are not allowed to delete");}

        $this->deviceRepository->destroy($id);

		return back()->withError("Device deleted");
    }


    //Custom function

    public function reset() // delete all element in the database
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withError("Nice try, but you are not allowed to reset the database");}
        
        $this->deviceRepository->reset();
        return redirect('device')->withOk("The database was deleted");
    }

    public function search() // Form Search for a device
    {
        $cat_array = $this->categoriesRepository->list_array();

        return view('devices/search', compact('cat_array'));
    }

    public function display(DevicesSearchRequest $request_receive) // Receive the answer of the previous form
    {
        $nbrPerPage = $this->nbrPerPage;
        $orderby = $this->orderby;

        if(isset($_SESSION['nbp']))
            $nbrPerPage = $_SESSION['nbp'];
        if(isset($_SESSION['orderby']))
            $orderby = $_SESSION['orderby'];

        $request = $request_receive->all();
        if($request!=Array())
            $_SESSION['search_crit'] = $request;
        else
            $request = $_SESSION['search_crit'];

        $devices = $this->deviceRepository->search($request, $nbrPerPage, $orderby);

        return view('devices/index', compact('devices'));
    }

    public function category($cat) // Display all the devices in the category $cat
    {
        $nbrPerPage = $this->nbrPerPage;
        $orderby = $this->orderby;

        if(isset($_SESSION['nbp']))
            $nbrPerPage = $_SESSION['nbp'];
        if(isset($_SESSION['orderby']))
            $orderby = $_SESSION['orderby'];

        $devices = $this->deviceRepository->search(['category' => $cat], $nbrPerPage, $orderby);

        $links = $devices->render();

        return view('devices/index', compact('devices', 'links'));
    }

    public function company($comp, $dept='') // Display all the devices in the category $cat
    {
        $nbrPerPage = $this->nbrPerPage;
        $orderby = $this->orderby;

        if(isset($_SESSION['nbp']))
            $nbrPerPage = $_SESSION['nbp'];
        if(isset($_SESSION['orderby']))
            $orderby = $_SESSION['orderby'];

        if($dept != '')
        {
            $devices = $this->deviceRepository->search(['company' => $comp, 'department' => $dept], $nbrPerPage, $orderby);
        }
        else
        {
            $devices = $this->deviceRepository->search(['company' => $comp], $nbrPerPage, $orderby);
        }

        $links = $devices->render();

        return view('devices/index', compact('devices', 'links'));
    }

    public function exportxls() // Export the database in an excel file for download
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withError("You don't have the right to get here");}

        $this->deviceRepository->export($this->categoriesRepository->getPaginate(0));
    }

    public function importxls(DevicesImportRequest $request) // Import the devices from the excel in request to the database
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withError("You don't have the right to get here");}

        if (!preg_match("/xlsx?$/", $request->file('file')->getClientOriginalExtension()))
        {
            return redirect('/device/import')->withError("Incorrect file type, must be .xls or .xlsx");
        }
        if($this->deviceRepository->verifxls($request->all()['file']))
        {
            $this->deviceRepository->import($request->all()['file'], $request->all()['company_id']);
            return redirect('/device')->withOk("File data added");
        }
        else
        {
            return redirect('/device/importxls')->withError("Incorrect file columns");
        }
    }

    public function import_gdrive() // Import the devices from the grive sheet in request to the database
    {   

        $googleClient = new Google_Client();
        $googleAuth = new GoogleAuth($googleClient);

        $fileId = '11l8tmiujIogsLaRWbU-bg-57Brp3Vr6gP8SJc3ha42Y'; // Id of the file might need to be changed
        $content = $googleAuth->getDrive($fileId);

        $file = fopen('swap_file', 'w');
        fwrite($file, $content);
        fclose($file);

        if($this->deviceRepository->verifxls('swap_file'))
        {
            $this->deviceRepository->import('swap_file');
            unlink('swap_file');
            return redirect('/device')->withOk("File data added");
        }
        else
        {
            unlink('swap_file');
            return redirect('/device/import')->withError("Incorrect file columns");
        }
    }

    public function itemPerPages(DevicesIndexRequest $request) // Call to change the number of items display by the index
    {
        $_SESSION['nbp'] = $request->all()['nbp'];

        return redirect()->to($this->getRedirectUrl())
                    ->withInput($request->input());
    }

    public function orderByChange(DevicesIndexRequest $request) // Call to change the order of items display by the index
    {
        $_SESSION['orderby'] = $request->all()['orderby'];

        return redirect()->to($this->getRedirectUrl())
                    ->withInput($request->input());
    }
}
