<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'reminder_interval' => Setting::get('reminder_interval', 180),
            'default_feed_type' => Setting::get('default_feed_type', 'breast_left'),
            'notifications_enabled' => Setting::get('notifications_enabled', true),
        ];

        return view('settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'reminder_interval' => 'required|integer|min:30|max:480',
            'default_feed_type' => 'required|in:breast_left,breast_right,bottle,formula',
            'notifications_enabled' => 'boolean',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully!');
    }
}
