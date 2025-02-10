<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\VideoUploadRequest;

class VideoController extends Controller
{
    public function upload(VideoUploadRequest $request) {
        $video = $request->file('video');
        $videoPath = 'videos/' . $video->hashName();
        Storage::disk('public')->put($videoPath, file_get_contents($video));

        // Video kaydını veritabanına ekle
        $videoDb = Video::create([
            'specs' => 1,
            'status' => 0,
            'hls_path' => null,
        ]);

        // İşleme sunucusuna gönder
        $processingServerUrl = 'http://processing-server.test/api/process';

        Log::info('Processing server URL: ' . $processingServerUrl);
        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->attach(
            'video', fopen($video->getRealPath(), 'r'), $video->getClientOriginalName()
        )->post($processingServerUrl, [
            'video_id' => $videoDb->id,
        ]);

        Log::info('Processing server response: ' . $response->body());

        if ($response->successful()) {
            Storage::disk('public')->delete($videoPath);
            return response_success('Video uploaded successfully');
        }

        return response_error('Failed to upload video', 500);
    }

    public function callback(Request $request)
    {
        $video = Video::find($request->video_id);

        if (!$video) {
            return response_error('Video not found', 404);
        }

        if ($request->has("hls_path")) {
            $video->hls_path = $request->hls_path;
        }

        if ($request->has("status")) {
            $video->status = $request->status;
        }

        $video->save();

        return response_success('Video updated successfully');
    }
}
