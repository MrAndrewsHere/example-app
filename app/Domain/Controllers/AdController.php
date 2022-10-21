<?php

namespace App\Domain\Controllers;

use App\Domain\DataTransferObjects\AdDTO;
use App\Domain\DataTransferObjects\AdsIndexDTO;
use App\Domain\Models\Ad;
use App\Domain\Models\Category;
use App\Domain\Requests\AdGetOneRequest;
use App\Domain\Requests\AdStoreRequest;
use App\Domain\Requests\AdUpdateRequest;
use App\Domain\Requests\AdViewRequest;
use App\Domain\Resources\AdCollection;
use App\Domain\Resources\AdResource;
use App\Domain\Services\AdService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class AdController extends Controller
{
    /**
     * @param  AdService  $service
     */
    public function __construct(protected AdService $service)
    {
    }

    /**
     * @param AdViewRequest $request
     * @return AdCollection|Response
     */
    public function index(AdViewRequest $request)
    {
        $ads = AdCollection::make($this->service->index(AdsIndexDTO::fromRequest($request)));
        if ($request->wantsJson()) {
            return $ads;
        }

        return Inertia::render('Manager', [
            'ads' => $ads,
        ]);
    }

    /**
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Ads/Create', [
            'categories' => Category::all()->toArray(),
        ]);
    }

    /**
     * @param AdStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdStoreRequest $request)
    {
        $this->service->store(AdDTO::fromRequest($request));

        return Redirect::route('manager');
    }

    /**
     * @param  Ad  $ad
     * @param  AdGetOneRequest  $request
     * @return AdResource|Response
     */
    public function edit(Ad $ad, AdGetOneRequest $request)
    {
        $ad = AdResource::make($ad);
        if ($request->wantsJson()) {
            return $ad;
        }

        return Inertia::render('Ads/Edit', [
            'ad' => $ad,
            'categories' => Category::all()->toArray(),
        ]);
    }

    /**
     * @param  AdUpdateRequest  $request
     */
    public function update(AdUpdateRequest $request)
    {
        $this->service->update(AdDTO::fromRequest($request));
        return Redirect::route('manager');
    }

    /**
     * @param  Ad  $ad
     */
    public function delete(Ad $ad)
    {
        $this->service->delete($ad);

        return Redirect::route('manager');
    }
}
