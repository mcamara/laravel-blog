<?php namespace Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest {

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
            'email'				=> 'required|email|unique:users,id',
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
