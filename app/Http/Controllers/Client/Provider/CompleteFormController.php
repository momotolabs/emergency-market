<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\City;
use App\Models\Company;
use App\Models\State;
use App\Models\User;
use App\StorableEvents\ParkingDeployCreated;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
// use MatanYadaev\EloquentSpatial\Objects\Point;
use MStaack\LaravelPostgis\Geometries\Point;

class CompleteFormController extends Controller
{
    public function create(Request $request)
    {
        return Inertia::render('Provider/CompleteForm', [
            'me' => $user = User::query()->where('id', $request->user()->id)->with(['providerProfile', 'company.city.state'])->first(),
            'states' => State::query()->orderBy('name')->get(['name', 'id']),
            'cities' => $user->company->city_id ? City::where('state_id', $user->company->city->state_id)->orderBy('name')->get() : [],
        ]);
    }

    public function update(ProfileRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = $request->user();

                $user->providerProfile()->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->cellphone,
                ]);
                $tempParkingCoordinates = new Point($request->parking_latitude, $request->parking_longitude);

                $slug = Str::slug($request->name);

                $companyNameSlug = Company::query()->where('slug', '=', Str::slug($request->name))->whereNot('id', '=', $user->company->id)->count();

                if ($companyNameSlug > 0) {
                    $companyNameSlugNew = $request->name.'-'.Carbon::now()->timestamp;
                    $slug = Str::slug($companyNameSlugNew);
                }

                $user->company()->update([
                    'name' => $request->name,
                    'slug' => $slug,
                    'address' => $request->address,
                    'state_id' => $request->state_id,
                    'city_id' => $request->city_id,
                    'description' => $request->description,
                    'kind' => $request->kind,
                    'miles' => $request->miles,
                    'parking_address' => $request->parking_address,
                    'parking_coordinates' => $tempParkingCoordinates, // DB::raw("POINT({$request->parking_latitude}, {$request->parking_longitude})"),
                    'phone' => $request->phone,
                    'address_coordinates' => new Point($request->latitude, $request->longitude), // DB::raw("POINT({$request->latitude}, {$request->longitude})"),
                    'social' => [
                        'google_link' => $request->google_link,
                        'website_link' => $request->website_link,
                        'youtube_link' => $request->youtube_link,
                    ],
                ]);
                event(new ParkingDeployCreated([
                    'user_id' => $user->id,
                    'company_id' => $user->company->id,
                    'parking_address' => $request->parking_address,
                    'parking_coordinates' => $tempParkingCoordinates,
                    'updated_at' => Carbon::now(),
                ]));
            });

            return to_route('provider.resources')->with('notification', [
                'type' => 'success',
                'message' => 'Profile update successfully',
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
