<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobView extends Model
{
    protected $table = 'job_views';

    protected $fillable = [
        'job_id',
        'viewer_id',
        'viewer_ip',
        'user_agent',
        'referrer',
        'is_logged_in',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function viewer()
    {
        return $this->belongsTo(User::class, 'viewer_id');
    }

    public static function logView(Request $request, Job $job): void
    {
        $viewer = Auth::user();

        // Do not count owner's own views.
        if ($viewer?->client?->id === $job->client_id) {
            return;
        }

        $viewerId = Auth::id();
        $viewerIp = $request->ip();
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();

        $existingQuery = static::query()
            ->where('job_id', $job->id)
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
            'job_id' => $job->id,
            'viewer_id' => $viewerId,
            'viewer_ip' => $viewerIp,
            'user_agent' => $request->userAgent(),
            'referrer' => $request->headers->get('referer'),
            'is_logged_in' => Auth::check(),
        ]);
    }
}
