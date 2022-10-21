<?php

namespace App\Domain\Controllers;

use App\Domain\DataTransferObjects\AdsIndexDTO;
use App\Domain\Requests\AdViewRequest;
use App\Domain\Resources\AdCollection;
use App\Domain\Services\AdService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    /**
     * @param AdViewRequest $request
     * @param AdService $service
     * @return \Inertia\Response
     */
    public function index(AdViewRequest $request, AdService $service): \Inertia\Response
    {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'ads' => AdCollection::make($service->index(AdsIndexDTO::fromRequest($request))),
        ]);
    }
}
