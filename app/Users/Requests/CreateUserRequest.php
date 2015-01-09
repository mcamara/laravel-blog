<?php namespace Blog\Users\Requests;

use Blog\Http\Requests\Request;

class CreateUserRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' 		=> 'required|alpha',
            'last_name' 		=> 'required|alpha',
            'email'				=> 'required|email',
            'profile_picture'	=> 'image'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Admins are the only ones able to create new users
        return $this->user()->isAdmin();
    }

}
