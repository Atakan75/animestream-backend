<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    public function upload(Request $request)
    {
        // Video doğrulama
        $request->validate([
            'video' => 'required|mimes:mp4,mkv,avi|max:1024000', // 1GB limit
        ]);

        // Video geçici olarak kaydet
        $video = $request->file('video');
        $videoPath = storage_path('app/public/videos/' . $video->hashName());
        $video->move(dirname($videoPath), basename($videoPath));

        // Video kaydını veritabanına ekle
        $videoDb = Video::create([
            'specs' => 1,
            'status' => 1,
            'hls_path' => null,
        ]);

        // İşleme sunucusuna gönder
        $processingServerUrl = 'http://processing-server.test/api/process';

        Log::info('Processing server URL: ' . $processingServerUrl);
        $response = Http::attach(
            'video', $video, $video->getClientOriginalName()
        )->post($processingServerUrl, [
            'video_id' => $videoDb->id,
        ]);

        Log::info('Processing server response: ' . $response->body());

        if ($response->successful()) {
            // Geçici dosyayı kaldır
            unlink($videoPath);
            return response()->json(['status' => 'Video uploaded successfully'], 200);
        }

        return response()->json(['error' => 'Failed to process video'], 500);
    }
}
