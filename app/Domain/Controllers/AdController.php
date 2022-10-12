<?php

namespace App\Domain\Controllers;

use App\Domain\Requests\AdDeleteRequest;
use App\Domain\Requests\AdGetOneRequest;
use App\Domain\Requests\AdStoreRequest;
use App\Domain\Requests\AdViewRequest;
use App\Domain\Resources\AdCollection;
use App\Domain\Resources\AdResource;
use App\Domain\Services\AdService;
use App\Http\Controllers\Controller;

class AdController extends Controller
{
    /**
     * @param AdService $service
     */
    public function __construct(protected AdService $service)
    {
    }

    /**
     * @param AdViewRequest $request
     * @return AdCollection
     */
    public function index(AdViewRequest $request)
    {
        return AdCollection::make($this->service->index($request->all(), $request->query()));
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
        return response()->json(['data' => $this->service->store($request->all())], 201);
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
