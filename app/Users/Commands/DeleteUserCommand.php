<?php namespace Blog\Users\Commands;

use Blog\Commands\Command;
use Blog\Users\UserRepository;
use Blog\Users\Exceptions\CannotDeleteLastUser;

class DeleteUserCommand extends Command {

    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct( UserRepository $repository )
    {
        $this->repository = $repository;
    }

    /**
     * @param $user_id
     * @throws Blog\Users\Exceptions\CannotDeleteLastUser
     * @return bool
     */
    public function delete( $user_id )
    {
        $user = $this->repository->find($user_id);

        if(count($this->repository->all()) === 1)
            throw new CannotDeleteLastUser;

        return $this->repository->destroy($user);
    }

}