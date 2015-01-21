<?php
namespace Users;


class UserRepository {

    /**
     * @var User
     */
    protected $user;

    /**
     * @param User $user
     */
    public function __construct( User $user )
    {
        $this->user = $user;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->user->all();
    }

    /**
     * @param $id
     * @return User
     */
    public function find( $id )
    {
        return $this->user->findOrFail($id);
    }

    /**
     * @param string $email
     * @return User
     */
    public function search( $email = false )
    {
        return $this->user->where('email', $email)->firstOrFail();

    }

    /**
     * @param User $user
     * @throws Illuminate\Database\QueryException
     * @return User|bool
     */
    public function save( User $user )
    {
        if ( $user->save() )
            return $user;

        return false;
    }

    /**
     * @param User $user
     * @return bool|null
     * @throws \Exception
     */
    public function destroy( User $user )
    {
        return $user->delete();
    }
}