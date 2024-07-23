<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client\Dashboard\Profile;

use App\Http\Controllers\Controller;
use App\Models\Multimedia;
use App\Traits\S3Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class MultimediaController extends Controller
{
    use S3Upload;

    public function create(Request $request)
    {
        return Inertia::render('Dashboard/Profile/Multimedia', [
            'avatar' => $request->user()->company?->getAvatar(),
            'gallery' => $request->user()->company?->getGallery(),
            'video' => $request->user()->company->main_video,
        ]);
    }

    public function avatar(Request $request)
    {
        $user = $request->user();
        $user->company->multimedia()->updateOrCreate([
            'type' => 'avatar',
        ], [
            // 'path' => $request->file('avatar')->storePublicly('/avatars', 's3'),
            'path' => $this->getUrl($request->file('avatar'), '/avatars'),
            'type' => 'avatar',
        ]);

        return back()->with('notification', [
            'message' => 'Logo uploaded',
        ]);
    }

    public function gallery(Request $request)
    {
        try {
            $user = $request->user();
            foreach ($request->images as $key => $value) {
                $user->company->multimedia()->create([
                    'path' => $this->getUrl($value, '/gallery', $key),
                    'type' => 'gallery',
                ]);
            }

            return back()->with('notification', [
                'message' => 'files uploaded',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('notification', [
                'type' => 'error',
                'message' => 'There was a problem processing the request', //'Please, check and complete the form',
            ]);
        }
    }

    public function deleteGallery(Request $request, Multimedia $multimedia)
    {
        if ($multimedia->publishable_id !== $request->user()->company->id) {
            return 'this is element is not assigned ';
        }

        $multimedia->delete();

        return back()->with('notification', [
            'message' => 'Delete successfully',
            'type' => '',
        ]);
    }

    public function mainVideo(Request $request)
    {
        $user = $request->user();

        $user->company->update([
            'main_video' => $request->video,
        ]);

        return back()->with('notification', [
            'message' => 'Main video updated',
        ]);
    }
}
