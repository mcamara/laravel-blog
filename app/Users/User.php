<?php namespace Users;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Hashing\BcryptHasher;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'first_name', 'last_name', 'email', 'is_admin' ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 'password', 'remember_token', 'profile_picture' ];

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    /**
     * Returns if this user is admin or not
     * @return bool
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function setPasswordAttribute( $password )
    {
        $hasher = new BcryptHasher();
        $this->attributes[ 'password' ] = $hasher->make($password);
    }

    public function setProfilePicture( $profile_picture )
    {

    }

}
