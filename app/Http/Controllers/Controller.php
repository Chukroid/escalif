<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController; // <-- This is the core Laravel Controller

abstract class Controller extends BaseController // <-- Your application's base controller extends Laravel's core
{
    use AuthorizesRequests, ValidatesRequests; // <-- These traits provide validate() and authorize()
}