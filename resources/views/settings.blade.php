<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Settings - nextFeed</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-dark-bg">
    <div class="min-h-screen">
        <div class="max-w-2xl mx-auto px-4 py-6">
            <header class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('feeding-logs.index') }}" class="p-3 rounded-xl hover:bg-gray-200 dark:hover:bg-dark-card transition-colors">
                        <svg class="w-6 h-6 text-gray-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Settings</h1>
                </div>
                <button onclick="toggleDarkMode()" class="p-3 rounded-xl bg-gray-200 dark:bg-dark-card text-gray-800 dark:text-text-secondary hover:bg-gray-300 dark:hover:bg-[#2a2d45] transition-colors">
                    <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </button>
            </header>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('settings.update') }}" class="space-y-4">
                @csrf

                <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-[#2a2d45] p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-5">Daily Target</h2>

                    <div class="space-y-4">
                        <div>
                            <label for="daily_target_ml" class="block text-sm font-medium text-gray-700 dark:text-text-secondary mb-2">
                                Daily Milk Target (ml)
                            </label>
                            <input
                                type="number"
                                name="daily_target_ml"
                                id="daily_target_ml"
                                min="400"
                                max="1200"
                                step="50"
                                value="{{ old('daily_target_ml', $settings['daily_target_ml']) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#2a2d45] bg-white dark:bg-dark-bg text-gray-900 dark:text-white focus:ring-2 focus:ring-accent focus:border-transparent transition-all"
                            >
                            <p class="mt-2 text-sm text-gray-500 dark:text-text-muted">
                                Recommended: 600-800ml for 7-week-old babies
                            </p>
                            @error('daily_target_ml')
                                <p class="mt-1 text-sm text-[#f56565]">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-[#2a2d45] p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-5">Reminders</h2>

                    <div class="space-y-5">
                        <div>
                            <label for="reminder_interval" class="block text-sm font-medium text-gray-700 dark:text-text-secondary mb-2">
                                Reminder Interval (minutes)
                            </label>
                            <input
                                type="number"
                                name="reminder_interval"
                                id="reminder_interval"
                                min="30"
                                max="480"
                                value="{{ old('reminder_interval', $settings['reminder_interval']) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#2a2d45] bg-white dark:bg-dark-bg text-gray-900 dark:text-white focus:ring-2 focus:ring-accent focus:border-transparent transition-all"
                            >
                            <p class="mt-2 text-sm text-gray-500 dark:text-text-muted">
                                Time between feedings ({{ floor($settings['reminder_interval'] / 60) }} hours {{ $settings['reminder_interval'] % 60 }} minutes)
                            </p>
                            @error('reminder_interval')
                                <p class="mt-1 text-sm text-[#f56565]">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                name="notifications_enabled"
                                id="notifications_enabled"
                                value="1"
                                {{ old('notifications_enabled', $settings['notifications_enabled']) ? 'checked' : '' }}
                                class="w-5 h-5 text-accent bg-gray-100 dark:bg-dark-bg border-gray-300 dark:border-[#2a2d45] rounded focus:ring-accent"
                            >
                            <label for="notifications_enabled" class="ml-3 text-sm font-medium text-gray-700 dark:text-text-secondary">
                                Enable reminder notifications
                            </label>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-[#2a2d45] p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-5">Timezone</h2>

                    <div>
                        <label for="timezone" class="block text-sm font-medium text-gray-700 dark:text-text-secondary mb-2">
                            Your Timezone
                        </label>
                        <select
                            name="timezone"
                            id="timezone"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#2a2d45] bg-white dark:bg-dark-bg text-gray-900 dark:text-white focus:ring-2 focus:ring-accent focus:border-transparent transition-all"
                        >
                            @foreach($timezones as $tz)
                                <option value="{{ $tz }}" {{ old('timezone', $settings['timezone']) === $tz ? 'selected' : '' }}>
                                    {{ $tz }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-sm text-gray-500 dark:text-text-muted">
                            Used for displaying feed times correctly
                        </p>
                        @error('timezone')
                            <p class="mt-1 text-sm text-[#f56565]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-[#2a2d45] p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-5">Default Feed Type</h2>

                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative cursor-pointer">
                            <input
                                type="radio"
                                name="default_feed_type"
                                value="breast_left"
                                {{ old('default_feed_type', $settings['default_feed_type']) === 'breast_left' ? 'checked' : '' }}
                                class="peer sr-only"
                            >
                            <div class="p-4 rounded-xl border-2 border-gray-300 dark:border-[#2a2d45] peer-checked:border-breast peer-checked:bg-breast/30 dark:peer-checked:bg-breast/10 text-center transition-all">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Left Breast</span>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input
                                type="radio"
                                name="default_feed_type"
                                value="breast_right"
                                {{ old('default_feed_type', $settings['default_feed_type']) === 'breast_right' ? 'checked' : '' }}
                                class="peer sr-only"
                            >
                            <div class="p-4 rounded-xl border-2 border-gray-300 dark:border-[#2a2d45] peer-checked:border-breast peer-checked:bg-breast/30 dark:peer-checked:bg-breast/10 text-center transition-all">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Right Breast</span>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input
                                type="radio"
                                name="default_feed_type"
                                value="bottle"
                                {{ old('default_feed_type', $settings['default_feed_type']) === 'bottle' ? 'checked' : '' }}
                                class="peer sr-only"
                            >
                            <div class="p-4 rounded-xl border-2 border-gray-300 dark:border-[#2a2d45] peer-checked:border-bottle peer-checked:bg-bottle/30 dark:peer-checked:bg-bottle/10 text-center transition-all">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Bottle</span>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input
                                type="radio"
                                name="default_feed_type"
                                value="formula"
                                {{ old('default_feed_type', $settings['default_feed_type']) === 'formula' ? 'checked' : '' }}
                                class="peer sr-only"
                            >
                            <div class="p-4 rounded-xl border-2 border-gray-300 dark:border-[#2a2d45] peer-checked:border-formula peer-checked:bg-formula/30 dark:peer-checked:bg-formula/10 text-center transition-all">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Formula</span>
                            </div>
                        </label>
                    </div>
                    @error('default_feed_type')
                        <p class="mt-2 text-sm text-[#f56565]">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-[#2a2d45] p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">About</h2>

                    <div class="space-y-2 text-sm text-gray-600 dark:text-text-secondary">
                        <p><strong class="text-gray-900 dark:text-white font-medium">nextFeed</strong> - Baby Feeding Tracker</p>
                        <p>Version 1.0.0</p>
                        <p class="pt-2">
                            <a href="https://github.com/laxmariappan/nextFeed" target="_blank" class="text-accent hover:text-accent-hover transition-colors">
                                View on GitHub
                            </a>
                        </p>
                        <p class="pt-4 text-xs text-gray-500 dark:text-text-muted">
                            Built with love for tired parents everywhere 💜
                        </p>
                    </div>
                </div>

                <div class="sticky bottom-0 bg-white dark:bg-dark-card border-t border-gray-200 dark:border-[#2a2d45] -mx-4 px-4 py-5">
                    <button
                        type="submit"
                        class="w-full bg-accent hover:bg-accent-hover text-white font-medium py-4 px-6 rounded-2xl active:scale-95 transition-all"
                    >
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }

        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>
</html>
