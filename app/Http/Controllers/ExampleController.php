<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    public function __invoke()
    {
        return response()->json();
    }
}
