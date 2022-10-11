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

    public function index(AdViewRequest $request): AdCollection
    {
        return new AdCollection($this->service->index($request->all(), $request->query()));
    }

    public function get(AdGetOneRequest $request): AdResource
    {
        return new AdResource($this->service->get($request->all()));
    }

    public function store(AdStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => $this->service->store($request->all())], 201);
    }

    public function delete(AdDeleteRequest $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => $this->service->delete($request->get('id'))]);
    }
}
