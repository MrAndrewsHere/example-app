<?php

namespace App\Domain\Controllers;

use App\Domain\DataTransferObjects\AdIndexDTO;
use App\Domain\Requests\AdIndexRequest;
use App\Domain\Resources\AdCollection;
use App\Domain\Services\AdService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class WelcomeController extends Controller
{
    /**
     * @param AdIndexRequest $request
     * @param AdService $service
     * @return Response
     */
    public function index(AdIndexRequest $request, AdService $service): Response
    {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'ads' => AdCollection::make($service->index(AdIndexDTO::fromRequest($request))),
        ]);
    }
}
