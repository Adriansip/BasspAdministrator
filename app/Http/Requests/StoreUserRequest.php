<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userName'=>'required|alpha|max:50',
            'userLastName'=>'required|alpha|max:50',
            'userMotherLastName'=>'required|alpha|max:50',
            'userNick'=>'required',
            'userPwd'=>'required',
            'userRolId'=>'required|numeric',
            'userLastAccessIP'=>'required',
            'userUniqueID'=>'required',
            'userEmail'=>'required|email|max:50',
            'userToken'=>'required',
            'userPhone'=>'required'
        ];
    }
}
