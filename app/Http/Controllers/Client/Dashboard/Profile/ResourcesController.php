<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client\Dashboard\Profile;

use App\Http\Controllers\Controller;
use App\Models\PricingResource;
use App\Models\Resource;
use App\StorableEvents\PricingResourceCreated;
use App\StorableEvents\PricingResourceUpdated;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ResourcesController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();

        return Inertia::render('Dashboard/Profile/Resources', [
            'resources' => Resource::query()->get(['id', 'name']),
            'pricingResources' => $user->company->pricingResource,
        ]);
    }

    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                '*.id' => ['nullable', Rule::exists(PricingResource::class, 'id')],
                '*.resource_id' => ['required', Rule::exists(Resource::class, 'id')],
                '*.minimum_units' => ['required', 'integer'],
                '*.price_cents' => ['required', 'integer'],
            ]);

            $user = $request->user();

            DB::transaction(function () use ($validatedData, $user) {
                foreach ($validatedData as $key => $value) {
                    $temp = PricingResource::updateOrCreate(
                        [
                            'company_id' => $user->company->id,
                            'id' => $value['id'],
                            'resource_id' => $value['resource_id'],
                        ],
                        [
                            'minimum_units' => $value['minimum_units'],
                            'price_cents' => $value['price_cents'],
                        ]
                    );

                    if (isset($value['id'])) {
                        event(new PricingResourceUpdated($temp->toArray()));
                    }

                    if (! isset($value['id'])) {
                        event(new PricingResourceCreated($temp->toArray()));
                    }
                }
            });

            return to_route('dashboard.profile.resources.index')->with('notification', [
                'type' => 'success',
                'message' => 'Resources update successfully',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('notification', [
                'type' => 'error',
                'message' => 'There was a problem processing the request', //'Please, check and complete the form',
            ]);
        }
    }
}
