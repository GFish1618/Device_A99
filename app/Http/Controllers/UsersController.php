<?php

namespace App\Http\Controllers;

session_start();

use Illuminate\Http\Request;

use App\Http\Requests\Users\UsersSearchRequest;
use App\Http\Requests\Users\UsersUpdateRequest;

use App\Repositories\UsersRepository;
//use \Auth;

class UsersController extends Controller
{
 
	protected $usersRepository;
	protected $nbrPerPage = 5;

	public function __construct(UsersRepository $usersRepository)
    {
        $this->middleware('auth');
		$this->usersRepository = $usersRepository;
	}


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withOk("You don't have the right to get here");}

        $nbrPerPage = $this->nbrPerPage;

        if(isset($_SESSION['nbp']))
            $nbrPerPage = $_SESSION['nbp'];

        $users = $this->usersRepository->getPaginate($nbrPerPage);

		return view('users/index', compact('users'));
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
    public function store()
    {
        
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
        if(auth()->user()->admin < 2) {return redirect('device')->withOk("You don't have the right to get here");}
        $user = $this->usersRepository->getById($id);

		return view('users/edit',  compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersUpdateRequest $request, $id)
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withOk("You don't have the right to get here");}
        $this->usersRepository->update($id, $request->all());
		
		return redirect('admin')->withOk("The user was updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withOk("You don't have the right to get here");}
        $this->usersRepository->destroy($id);

		return back();
    }

    public function search()
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withOk("You don't have the right to get here");}
        return view('users/search');
    }

    public function display(UsersSearchRequest $request)
    {
        if(auth()->user()->admin < 2) {return redirect('device')->withOk("You don't have the right to get here");}
        $users = $this->usersRepository->search($request->all(), $this->nbrPerPage);

        $links = $users->render();

        return view('users/index', compact('users', 'links'));

    }

    public function googleLogout()
    {
        unset($_SESSION['access_token']);

        return view('users/logout');
    }

    // To delete in final version (auto fill of the form)
    /*public function GetForm()
    {
        $file='EquipmentReleaseResponsibilityFormTemplate.rtf';
        $newFile='EquipmentReleaseResponsibilityForm.rtf';

        $text=fopen($file,'r') or die("File missing"); 
        $content=file_get_contents($file); 
        $contentMod=str_replace('_____________', 'test', $content);
        fclose($text); 

        $text2=fopen($newFile,'w+') or die("File missing"); 
        fwrite($text2,$contentMod); 
        fclose($text2);
    }*/
}
