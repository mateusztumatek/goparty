<?php

namespace App\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;

class UserStoreCrudRequest extends CrudRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|unique:'.config('laravel-permission.table_names.users', 'users').',email',
            'first_name'     => 'required',
            'last_name'     => 'required',
            'password' => 'required|confirmed',
        ];
    }
}
