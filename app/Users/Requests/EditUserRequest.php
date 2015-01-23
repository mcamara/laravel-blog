<?php namespace Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'email'           => 'required|email|unique:email,users,' . $this->get('users'),
            'profile_picture' => 'image'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        dd($this->get('users'));
        // Admins and the own user are able to update a profile
        return $this->user()->isAdmin() || $this->user()->id === $this->get('users');
    }

}