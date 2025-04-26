<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisteredUserRequest;

class RegisteredUserController extends Controller
{
    public function create() 
    {
        return view('/auth/register');
    }

    public function store (RegisteredUserRequest $registeredUserRequest)
    {
        dd($registeredUserRequest);   
    }
}
