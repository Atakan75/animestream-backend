<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WatchHistory;


class UserWatchHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $watchHistories = WatchHistory::with([
            'episode' => function ($query) {
                $query->with([
                    'anime' => function ($query) {
                        $query->with([
                            'season'
                        ]);
                    },
                ]);
            }
        ])->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($watchHistories);
    }
}
