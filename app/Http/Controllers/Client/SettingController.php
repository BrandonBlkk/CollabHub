<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        return view('client.settings');
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'language' => 'sometimes|in:en,my',
            'timezone' => 'sometimes|timezone',
            'currency' => 'sometimes|in:USD,MMK,EUR,GBP,CAD,AUD',
            'dark_mode' => 'sometimes|boolean',
            'email_project_updates' => 'sometimes|boolean',
            'email_new_messages' => 'sometimes|boolean',
            'email_payments' => 'sometimes|boolean',
            'email_marketing' => 'sometimes|boolean',
            'profile_visibility' => 'sometimes|in:public,clients_only,freelancers_only,private',
            'show_online_status' => 'sometimes|boolean',
        ]);

        // Convert string boolean values to actual booleans
        foreach ($validated as $key => $value) {
            if (in_array($key, [
                'dark_mode',
                'email_project_updates',
                'email_new_messages',
                'email_payments',
                'email_marketing',
                'show_online_status'
            ])) {
                $validated[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }
        }

        $user->settings()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully'
        ]);
    }

    public function reset(Request $request)
    {
        $user = $request->user();

        // Create settings
        $user->settings()->update([
            'user_id' => $user->id,
            'language' => 'en',
            'currency' => 'USD',
            'timezone' => 'UTC',
            'dark_mode' => false,
            'email_project_updates' => true,
            'email_new_messages' => true,
            'email_payments' => true,
            'email_marketing' => false,
            'profile_visibility' => 'public',
            'show_online_status' => true,
            'show_earnings' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Settings reset to default successfully'
        ]);
    }
}
