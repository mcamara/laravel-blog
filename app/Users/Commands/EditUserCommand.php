<?php namespace Users\Commands;

use Blog\Commands\Command;
use Users\User;
use Users\UserRepository;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Events\Dispatcher;

class EditUserCommand extends Command implements SelfHandling {

    /**
     * @var Array
     */
    private $data;
    /**
     * @var
     */
    private $user_id;


    /**
     * @param $user_id
     * @param $data
     */
    public function __construct( $user_id, $data )
    {
        $this->data = $data;
        $this->user_id = $user_id;
    }


    /**
     * @param UserRepository $repository
     * @param Dispatcher $event
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws Illuminate\Database\QueryException
     * @return User|bool
     */
    public function handle( UserRepository $repository, Dispatcher $event )
    {
        $user = $repository->find($this->user_id);

        $user->first_name = $this->data[ 'first_name' ];
        $user->last_name = $this->data[ 'last_name' ];
        $user->email = $this->data[ 'email' ];
        $user->is_admin = $this->data[ 'is_admin' ];

        if ( isset( $this->data[ 'password' ] ) )
        {
            $user->password = $this->data[ 'password' ];
        }

        if ( isset( $this->data[ 'profile_picture' ] ) )
        {
            $user->setProfilePicture($this->data[ 'profile_picture' ]);
        }

        if ( $user = $repository->save($user) )
        {
            $event->fire('UserEdited', [ $user ]);

            return $user;
        }

        return false;
    }
}