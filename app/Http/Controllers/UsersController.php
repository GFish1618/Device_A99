<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\Users\UsersSearchRequest;
use App\Http\Requests\Users\UsersUpdateRequest;

use App\Repositories\UsersRepository;

class UsersController extends Controller
{
 
	protected $usersRepository;
	protected $nbrPerPage = 7;

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

        $users = $this->usersRepository->getPaginate($this->nbrPerPage);
		$links = $users->render();

		return view('users_list', compact('users', 'links'));
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
        $user = $this->usersRepository->getById($id);

		return view('user_edit',  compact('user'));
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
        $this->usersRepository->destroy($id);

		return back();
    }

    public function search()
    {
        return view('user_search');
    }

    public function display(UsersSearchRequest $request)
    {
        $users = $this->usersRepository->search($request->all(), $this->nbrPerPage);

        $links = $users->render();

        return view('users_list', compact('users', 'links'));

    }
}
