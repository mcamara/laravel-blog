<?php namespace Blog\Users\Commands;

use Blog\Commands\Command;
use Blog\Users\User;
use Blog\Users\UserRepository;
use Illuminate\Contracts\Events\Dispatcher;

class EditUserCommand extends Command {

    /**
     * @var Dispatcher
     */
    protected $event;
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct( UserRepository $repository, Dispatcher $event )
    {
        $this->repository = $repository;
        $this->event = $event;
    }


    /**
     * @param $user_id
     * @param array $data
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws Illuminate\Database\QueryException
     * @return User|bool
     */
    public function edit( $user_id, Array $data )
    {
        $user = $this->repository->find($user_id);

        $user->first_name = $data[ 'first_name' ];
        $user->last_name = $data[ 'last_name' ];
        $user->email = $data[ 'email' ];
        $user->is_admin = $data[ 'is_admin' ];

        if ( isset( $data[ 'password' ] ) )
        {
            $user->password = $data[ 'password' ];
        }

        if ( isset( $data[ 'profile_picture' ] ) )
        {
            $user->setProfilePicture( $data[ 'profile_picture' ] );
        }


        if($user = $this->repository->save($user))
        {
            $this->event->fire('UserEdited', [ $user ]);
            return $user;
        }

        return false;
    }
}