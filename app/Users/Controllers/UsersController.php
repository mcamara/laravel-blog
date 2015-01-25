<?php namespace Users\Controllers;

use Exception;
use Users\Commands\CreateUserCommand;
use Users\Commands\DeleteUserCommand;
use Users\Commands\EditUserCommand;
use Users\Requests\CreateUserRequest;
use Users\Requests\DeleteUserRequest;
use Users\Requests\EditUserRequest;
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
        $this->middleware('Users\Middleware\AdminAccess', [ 'except' => [ 'show', 'edit', 'update' ] ]);
        $this->middleware('Users\Middleware\UserAccess', [ 'only' => [ 'edit', 'update' ] ]);
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
        try
        {
            $user = $this->dispatch(new CreateUserCommand($request->only([
                'first_name',
                'last_name',
                'email',
                'password',
                'is_admin'
            ])));

            return redirect()->action('UsersController@show', [ $user->id ]);
        } catch ( Exception $e )
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
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

        return view('users.show', [ 'user' => $user ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit( $id )
    {
        $user = $this->repository->find($id);

        return view('users.edit', [ 'user' => $user ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param EditUserRequest $request
     * @return Response
     */
    public function update( $id, EditUserRequest $request )
    {
        try
        {
            $user = $this->dispatch(new EditUserCommand($id, $request->only([
                'first_name',
                'last_name',
                'email',
                'password',
                'is_admin'
            ])));

            return redirect()->action('UsersController@show', [ $user->id ]);
        } catch ( Exception $e )
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param DeleteUserRequest $request
     * @return Response
     */
    public function destroy( $id, DeleteUserRequest $request )
    {
        try
        {
            $this->dispatch(new DeleteUserCommand($id));

            return redirect()->action('UsersController@index');
        } catch ( Exception $e )
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

}
