<?php
namespace Blog\Users;


class UserRepository {

    protected $user;

    public function __construct( User $user )
    {
        $this->user = $user;
    }

    public function all()
    {
        return $this->user->all();
    }

    public function find( $id )
    {
        return $this->user->findOrFail($id);
    }

    public function search( $email = false )
    {
        return $this->user->where('email', $email)->get()->first();

    }

    public function save( User $user )
    {
        if ( $user->save() )
            return $user;

        return false;
    }

    public function destroy( User $user )
    {
        return $user->delete();
    }
}