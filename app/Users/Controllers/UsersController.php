<?php namespace Users\Controllers;

use Users\Commands\CreateUserCommand;
use Users\Requests\CreateUserRequest;
use Users\UserRepository;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UsersController extends BaseController {

    use DispatchesCommands, ValidatesRequests;

    /**
     * @var UserRepository
     */
    private $repository;

    function __construct( UserRepository $repository )
    {
        $this->repository = $repository;
        $this->middleware('Users\Middleware\AdminAccess', [ 'except' => 'show' ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->repository->all();
        return view('users.index', [ 'users' => $users ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return Response
     */
    public function store( CreateUserRequest $request )
    {
        $user = $this->dispatch(new CreateUserCommand($request->only([
            'first_name',
            'last_name',
            'email',
            'password',
            'is_admin'
        ])));

        return view('users.show', [ 'user' => $user ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show( $id )
    {
        $user = $this->repository->find($id);

        return view('users.index', [ 'user' => $user ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit( $id )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update( $id )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy( $id )
    {
        //
    }

}
