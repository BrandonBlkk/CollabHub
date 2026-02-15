<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileView extends Model
{
    protected $table = 'profile_views';

    protected $fillable = [
        'profile_user_id',
        'viewer_id',
        'viewer_ip',
        'user_agent',
        'referrer',
        'is_logged_in',
    ];

    public function profileUser()
    {
        return $this->belongsTo(User::class, 'profile_user_id');
    }

    public function viewer()
    {
        return $this->belongsTo(User::class, 'viewer_id');
    }

    public static function logView(Request $request, User $profileUser): void
    {
        if (Auth::id() === $profileUser->id) {
            return;
        }

        $viewerId = Auth::id();
        $viewerIp = $request->ip();
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();

        $existingQuery = static::query()
            ->where('profile_user_id', $profileUser->id)
            ->whereBetween('created_at', [$todayStart, $todayEnd]);

        if ($viewerId) {
            $existingQuery->where('viewer_id', $viewerId);
        } else {
            $existingQuery->whereNull('viewer_id')
                ->where('viewer_ip', $viewerIp);
        }

        if ($existingQuery->exists()) {
            return;
        }

        static::create([
            'profile_user_id' => $profileUser->id,
            'viewer_id' => $viewerId,
            'viewer_ip' => $viewerIp,
            'user_agent' => $request->userAgent(),
            'referrer' => $request->headers->get('referer'),
            'is_logged_in' => Auth::check(),
        ]);
    }
}
