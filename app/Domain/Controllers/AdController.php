<?php

namespace App\Domain\Controllers;

use App\Domain\DataTransferObjects\AdDTO;
use App\Domain\DataTransferObjects\AdIndexDTO;
use App\Domain\Models\Ad;
use App\Domain\Models\Category;
use App\Domain\Requests\AdDeleteRequest;
use App\Domain\Requests\AdGetRequest;
use App\Domain\Requests\AdStoreRequest;
use App\Domain\Requests\AdUpdateRequest;
use App\Domain\Requests\AdIndexRequest;
use App\Domain\Resources\AdCollection;
use App\Domain\Resources\AdResource;
use App\Domain\Services\AdService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
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

    /**
     * @param AdIndexRequest $request
     * @return AdCollection|Response
     */
    public function index(AdIndexRequest $request)
    {
        $ads = AdCollection::make($this->service->index(AdIndexDTO::fromRequest($request)));
        if ($request->wantsJson()) {
            return $ads;
        }

        return Inertia::render('Manager', [
            'ads' => $ads,
        ]);
    }


    /**
     * @return JsonResponse|Response
     */
    public function create()
    {
        if (request()->wantsJson()) {
            return response()->json([]);
        }

        return Inertia::render('Ads/Create', [
            'categories' => Category::all()->toArray(),
        ]);
    }

    /**
     * @param AdStoreRequest $request
     * @return AdResource|RedirectResponse
     */
    public function store(AdStoreRequest $request)
    {
        $ad = $this->service->store(AdDTO::fromRequest($request));
        $ad = AdResource::make($ad);
        if ($request->wantsJson()) {
            return AdResource::make($ad);
        }

        return Redirect::route('manager')->with('success', true);
    }

    /**
     * @param Ad $ad
     * @param AdGetRequest $request
     * @return AdResource|Response
     */
    public function edit(AdGetRequest $request, Ad $ad)
    {
        $ad = AdResource::make($ad);
        if ($request->wantsJson()) {
            return AdResource::make($ad);
        }

        return Inertia::render('Ads/Edit', [
            'ad' => $ad,
            'categories' => Category::all()->toArray(),
        ]);
    }

    /**
     * @param AdUpdateRequest $request
     */
    public function update(AdUpdateRequest $request, Ad $ad)
    {
        $ad = $this->service->update(AdDTO::fromRequest($request));
        if ($request->wantsJson()) {
            return AdResource::make($ad);
        }
        return Redirect::route('manager')->with('success', true);
    }

    /**
     * @param Ad $ad
     */
    public function destroy(Ad $ad, AdDeleteRequest $request)
    {
        $this->service->delete($request->get('id'));
        if ($request->wantsJson()) {
            return response()->json(['data' => true]);
        }
        return Redirect::route('manager')->with('success', true);
    }
}
