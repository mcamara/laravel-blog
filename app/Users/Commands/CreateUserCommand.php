<?php namespace Blog\Users\Commands;

use Blog\Commands\Command;
use Blog\Users\User;
use Blog\Users\UserRepository;
use Illuminate\Contracts\Events\Dispatcher;

class CreateUserCommand extends Command {

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

    public function create( Array $data )
    {
        if ( empty( $data[ 'password' ] ) )
            $data[ 'password' ] = str_random(10);

        $user = new User($data);
        $user->password = $data[ 'password' ];

        if ( isset( $data[ 'profile_picture' ] ) )
        {
            $user->setProfilePicture($data[ 'profile_picture' ]);
        }

        $this->event->fire('UserCreated', [ $user, $data['password'] ]);

        return $this->repository->save($user);
    }
}