<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client\Dashboard\Profile;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Company;
use App\Models\State;
use App\Models\User;
use App\StorableEvents\ParkingDeployChanged;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;
use MStaack\LaravelPostgis\Geometries\Point;

class IndexController extends Controller
{
    public function create(Request $request)
    {
        return Inertia::render('Dashboard/Profile/Index', [
            'me' => $user = User::query()->where('id', $request->user()->id)->with(['providerProfile', 'company.city.state'])->first(),
            'states' => State::query()->get(['name', 'id']),
            'cities' => City::where('state_id', $user->company->city->state_id)->get(),
            'contract_url' => $user->company->getContractUrl(),
        ]);
    }

    public function update(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = $request->user();

                $user->providerProfile()->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->cellphone,
                    'signature' => $request->signature,
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
                event(new ParkingDeployChanged([
                    'user_id' => $user->id,
                    'user_change_id' => $user->id,
                    'company_id' => $user->company->id,
                    'parking_address' => $request->parking_address,
                    'parking_coordinates' => $tempParkingCoordinates,
                    'updated_at' => Carbon::now(),
                ]));
            });

            return to_route('dashboard.profile.index')->with('notification', [
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
