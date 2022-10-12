<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;

class ExampleController extends Controller
{
    public function __invoke()
    {
        return response()->json();
    }
}
