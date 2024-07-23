<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait S3Upload
{
    public function getUrl(mixed $file, string $folder = '/', $count = ''): string
    {
        $url = config('services.default.img');
        try {
            $filename = 'emergency-'.time().''.$count.'.'.$file->extension();
            $image = Storage::disk('s3')->putFileAs($folder, $file, $filename, 'public');
            if (isset($image)) {
                $url = Storage::disk('s3')->url($image);
            }

            return $url;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return $url;
        }
    }

    public function deleteObject(string $file, string $folder = '/')
    {
        try {
            $name = explode('/', $file);
            Storage::disk('s3')->delete($folder.'/'.$name[4]);
        } catch (Exception $exception) {
            Log::error('NOT DELETE FILE'.$exception->getMessage());
        }
    }
}
