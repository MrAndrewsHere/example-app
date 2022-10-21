<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'code' => 200,
            'message' => 'SUCCESS',
        ]);
    }
}
