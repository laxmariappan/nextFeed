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
            'daily_target_ml' => Setting::get('daily_target_ml', 700),
            'timezone' => Setting::get('timezone', 'Asia/Kolkata'),
        ];

        $timezones = \DateTimeZone::listIdentifiers();

        return view('settings', compact('settings', 'timezones'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'reminder_interval' => 'required|integer|min:30|max:480',
            'default_feed_type' => 'required|in:breast_left,breast_right,bottle,formula',
            'notifications_enabled' => 'boolean',
            'daily_target_ml' => 'required|integer|min:400|max:1200',
            'timezone' => 'required|timezone',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully!');
    }
}
