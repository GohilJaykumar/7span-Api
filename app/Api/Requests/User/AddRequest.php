<?php

namespace App\Api\Requests\User;
use App\Api\Requests\Request;

class AddRequest extends Request
{
    public function rules()
    {
        return [
            'first_name'        => 'required|string|max:55',
            'last_name'        => 'required|string|max:55',
            'email'       => 'required|string|email|max:100|unique:users',
            'password'    => 'required|string|min:6',
            'photo'    => 'required|mimes:jpeg,png',
            'phone'    => 'required|digits:10',
            'status'    => 'required|in:Active,Deactive',
        ];
    }
}
