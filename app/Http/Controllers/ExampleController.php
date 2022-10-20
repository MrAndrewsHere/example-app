<?php

namespace App\Http\Controllers;

use App\Jobs\ExampleJob;

class ExampleController extends Controller
{
    public function __invoke()
    {

        return response()->json([
            'code' => 200,
            'message' => 'SUCCESS'
        ]);
    }
}
