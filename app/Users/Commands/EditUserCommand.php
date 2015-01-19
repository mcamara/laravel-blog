<?php namespace Blog\Users\Commands;

use Blog\Commands\Command;
use Blog\Users\User;
use Blog\Users\UserRepository;
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
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws Illuminate\Database\QueryException
     * @return User|bool
     */
    public function edit( UserRepository $repository )
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
            $this->event->fire('UserEdited', [ $user ]);

            return $user;
        }

        return false;
    }
}