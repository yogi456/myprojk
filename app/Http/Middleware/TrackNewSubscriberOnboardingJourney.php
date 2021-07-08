<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\SubscriberOnboardingJourney;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CustomLog;

class TrackNewSubscriberOnboardingJourney
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // CustomLog::LOG('full url', $request->fullUrl());
        if (!$request->ajax() &&  Auth::check() && $request->session()->has('track_new_subscriber')) {
            $device_type = session('device_type');
            $user = Auth::user();
            SubscriberOnboardingJourney::create([
                'subscriber_id' => $user->parent_id,
                'user_id' => $user->id,
                'registration_step' => session('track_new_subscriber'),
                'session_id' => session()->getId(),
                'device_type' => $device_type,
                'url' => $request->fullUrl()
            ]);
        }
        return $next($request);
    }
}
