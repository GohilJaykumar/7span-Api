<?php

namespace App\Api\Requests\UserHobby;
use App\Api\Requests\Request;

class AddRequest extends Request
{
    public function rules()
    {
        return [
            'hobby_id' => 'required|int|exists:hobbies,id',
        ];
    }
}
