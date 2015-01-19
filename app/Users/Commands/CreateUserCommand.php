<?php namespace Blog\Users\Commands;

use Blog\Commands\Command;
use Blog\Users\User;
use Blog\Users\UserRepository;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class CreateUserCommand extends Command implements SelfHandling {

    /**
     * @var array
     */
    private $data;

    public function __construct( $userData )
    {
        $this->data = $userData;
    }

    /**
     * @param UserRepository $repository
     * @param Dispatcher $event
     * @throws QueryException
     * @return User|bool Returns the user recently saved
     */
    public function handle( UserRepository $repository, Dispatcher $event )
    {
        if ( empty( $data[ 'password ' ] ) )
            $data[ 'password ' ] = str_random(10);

        $user = new User($this->data);

        $randomPassword = false;

        if ( !isset( $data[ 'password' ] ) )
        {
            $data[ 'password' ] = Str::random(10);
            $randomPassword = true;
        }

        $user->password = $data[ 'password' ];

        if ( isset( $data[ 'profile_picture ' ] ) )
        {
            $user->setProfilePicture($data[ 'profile_picture' ]);
        }

        if ( $user = $repository->save($user) )
        {
            $event->fire('UserCreated', [ $user, $randomPassword ? $data[ 'password' ] : false ]);

            return $user;
        }

        return false;
    }
}