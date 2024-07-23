<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client\Dashboard\Extras;

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
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Dashboard/Extras/Index');
    }

    public function download()
    {
        return Storage::disk('public')->download("emergency Sample Contract.docx");
    }
}
