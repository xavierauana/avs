<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Role;

class UserCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !! $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|min:3',
            'password'=>'required|min:3|confirmed',
            'email'=>'required|email|unique:users',
            'role.*'=>'required|in:'.implode(',', Role::lists('id')->toArray())
        ];
    }
}
