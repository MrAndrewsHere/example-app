<?php

namespace App\Domain\Controllers;

use App\Domain\DataTransferObjects\AdDTO;
use App\Domain\DataTransferObjects\AdsViewDTO;
use App\Domain\Models\Ad;
use App\Domain\Models\Category;
use App\Domain\Requests\AdDeleteRequest;
use App\Domain\Requests\AdGetOneRequest;
use App\Domain\Requests\AdStoreRequest;
use App\Domain\Requests\AdViewRequest;
use App\Domain\Resources\AdCollection;
use App\Domain\Resources\AdResource;
use App\Domain\Services\AdService;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AdController extends Controller
{
    /**
     * @param AdService $service
     */
    public function __construct(protected AdService $service)
    {
    }

    public function index(AdViewRequest $request)
    {


        $ads = AdCollection::make($this->service->index(AdsViewDTO::fromRequest($request)));
        if ($request->wantsJson()) {
            return $ads;
        }
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'ads' => $ads
        ]);
    }

    /**
     * @param AdGetOneRequest $request
     * @return AdResource
     */
    public function get(AdGetOneRequest $request)
    {
        return AdResource::make($this->service->get($request->all()));
    }

    /**
     * @param AdStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AdStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => $this->service->store(AdDTO::fromRequest($request))], 201);
    }

    /**
     * @param AdDeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(AdDeleteRequest $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => $this->service->delete($request->get('id'))]);
    }
}
