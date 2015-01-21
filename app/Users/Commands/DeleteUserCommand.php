<?php namespace Users\Commands;

use Blog\Commands\Command;
use Users\UserRepository;
use Users\Exceptions\CannotDeleteLastUser;
use Illuminate\Contracts\Bus\SelfHandling;

class DeleteUserCommand extends Command implements SelfHandling {


    /**
     * @var integer
     */
    private $user_id;

    public function __construct( $user_id )
    {
        $this->user_id = $user_id;
    }

    /**
     * @param UserRepository $repository
     * @return bool
     * @throws CannotDeleteLastUser
     */
    public function handle( UserRepository $repository )
    {
        $user = $repository->find($this->user_id);

        if(count($repository->all()) === 1)
            throw new CannotDeleteLastUser;

        return $repository->destroy($user);
    }

}