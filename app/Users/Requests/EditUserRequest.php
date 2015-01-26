<?php namespace Users\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Routing\Route;

class EditUserRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'      => 'required|alpha',
            'last_name'       => 'required|alpha',
            'email'           => 'required|email|unique:users,email' . $this->get('users'),
            'profile_picture' => 'image'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Route $router
     * @return bool
     */
    public function authorize(Route $router)
    {
        // Admins and the own user are able to update a profile
        return $this->user()->isAdmin() || $this->user()->id === $router->parameter('users');
    }

}