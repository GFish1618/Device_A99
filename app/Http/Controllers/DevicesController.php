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

use Excel;
use Socialite;
use User;
use Auth;
use \Google_Client; 
use \Google_Service_Drive;


class DevicesController extends Controller
{
 
	protected $deviceRepository;
	protected $nbrPerPage = 5;
    protected $orderby = 'id';

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
        $nbrPerPage = $this->nbrPerPage;
        $orderby = $this->orderby;

        if(isset($_SESSION['nbp']))
            $nbrPerPage = $_SESSION['nbp'];
        if(isset($_SESSION['orderby']))
            $orderby = $_SESSION['orderby'];
        
        $devices = $this->deviceRepository->getPaginate($nbrPerPage, $orderby);

		return view('index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->admin < 1) {return redirect('device')->withError("You don't have the right to get here");}

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
        if(auth()->user()->admin < 1) {return redirect('device')->withError("You don't have the right to get here");}

        $response = $this->deviceRepository->store($request->all());

        if ($response['success']=='true')
            return redirect('device')->withOk("The device: " . $response['name'] . " was created");
        else
            return redirect('/device/'.$response['sibling'])->withError("This device already exists, see below");

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
        if(auth()->user()->admin < 1) {return redirect('device')->withError("You don't have the right to get here");}

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
        if(auth()->user()->admin < 1) {return redirect('device')->withError("You don't have the right to get here");}

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
        if(auth()->user()->admin < 2) {return redirect('device')->withError("You are not allowed to delete");}
        $this->deviceRepository->destroy($id);

		return back();
    }

    public function reset()
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withError("Nice try, but you are not allowed to reset the database");}
        
        $this->deviceRepository->reset();
        return redirect('device')->withOk("The database was deleted");
    }

    public function search()
    {
        return view('search');
    }

    public function display(DevicesSearchRequest $request_receive)
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

        return view('index', compact('devices'));
    }

    public function category($cat)
    {
        $nbrPerPage = $this->nbrPerPage;
        $orderby = $this->orderby;

        if(isset($_SESSION['nbp']))
            $nbrPerPage = $_SESSION['nbp'];
        if(isset($_SESSION['orderby']))
            $orderby = $_SESSION['orderby'];

        $devices = $this->deviceRepository->search(['category' => $cat], $nbrPerPage, $orderby);

        $links = $devices->render();

        return view('index', compact('devices', 'links'));
    }

    public function exportxls()
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withError("You don't have the right to get here");}

        $this->deviceRepository->export();
    }

    public function importxls(DevicesImportRequest $request)
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withError("You don't have the right to get here");}

        echo $request->all()['file']."<br>";
        if($this->deviceRepository->verifxls($request->all()['file']))
        {
            $this->deviceRepository->import($request->all()['file']);
            return redirect('/device')->withOk("File data added");
        }
        else
        {
            return redirect('/device/import')->withError("Incorrect file columns");
        }
    }

    public function import_gdrive()
    {
        $path = 'gpaenkordecidelenom';


        /*$client = new Google_Client();
        $client->setAuthConfig(env('GOOGLE_API_KEY'));
        $client->setApprovalPrompt('force');
        $client->addScope("https://www.googleapis.com/auth/drive");

        $service = new Google_Service_Drive($client);


        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['upload_token'] = $client->getAccessToken();
            $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
        }
        else{
            echo 'truc';
        }

        if (isset($_SESSION['upload_token']) && $_SESSION['upload_token']) {
            $client->setAccessToken($_SESSION['upload_token']);
            if ($client->isAccessTokenExpired()) {
                unset($_SESSION['upload_token']);
            }
        }
        else{
            echo 'machin';
        }

        if ($client->getAccessToken()) {
            $fileId = '11l8tmiujIogsLaRWbU-bg-57Brp3Vr6gP8SJc3ha42Y';
            $response = $service->files->export($fileId, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', array('alt' => 'media' ));
            $content = $response->getBody()->getContents();
        }
        else{
            echo 'rien';
        }*/

        $userg = new Google_Client();
        $userg->setAuthConfig(env('GOOGLE_API_KEY'));
        $userg->addScope("https://www.googleapis.com/auth/drive.readonly");

        //$userg->setAccessToken($socialUser->token);

        $userg->setAccessToken([
          'access_token' => auth()->user()->remember_token,
          'expires_in'   => 3600,
          'created'      => time(),
        ]);

        //echo($socialUser->token);

        $service = new Google_Service_Drive($userg);

        $fileId = '11l8tmiujIogsLaRWbU-bg-57Brp3Vr6gP8SJc3ha42Y';
        $response = $service->files->export($fileId, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', array('alt' => 'media' ));
        $content = $response->getBody()->getContents();

        //$file = fopen('test.xls', 'w');
        //fwrite($file, $content);
        //fclose($file);
        
        /*if($this->deviceRepository->verifxls($path))
        {

            $this->deviceRepository->import($path);
            return redirect('/device')->withOk("Gdrive data added");
        }
        else
        {
            return redirect('/device/import')->withError("Incorrect file columns");
        }*/

        return back();
    }

    public function addCategoryForm()
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withError("You don't have the right to get here");}

        return view('addCategory');
    }

    public function addCategoryPost(DevicesCategoryRequest $request)
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withError("You don't have the right to get here");}

        $test = $request->all();
        FileRepository::addCategory(strtolower($test['new_category']));
        return redirect('admin/categories')->withOk('The category '.$test['new_category'].' was added');
    }

    public function deleteCategory(DevicesCategoryRequest $request)
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withError("You don't have the right to get here");}

        $test = $request->all();
        FileRepository::deleteCategory(strtolower($test['category']));
        return redirect('admin/categories')->withOk('The category '.$test['category'].' was deleted');
    }

    public function itemPerPages(DevicesIndexRequest $request)
    {
        $_SESSION['nbp'] = $request->all()['nbp'];

        return redirect()->to($this->getRedirectUrl())
                    ->withInput($request->input());
    }

    public function orderByChange(DevicesIndexRequest $request)
    {
        $_SESSION['orderby'] = $request->all()['orderby'];

        return redirect()->to($this->getRedirectUrl())
                    ->withInput($request->input());
    }
}
