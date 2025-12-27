<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stats - nextFeed</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-dark-bg">
    <div class="min-h-screen pb-6">
        <div class="max-w-2xl mx-auto px-4 py-6">
            <header class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('feeding-logs.index') }}" class="p-3 rounded-xl hover:bg-gray-200 dark:hover:bg-dark-card transition-colors">
                        <svg class="w-6 h-6 text-gray-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Statistics</h1>
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

            {{-- View Selector --}}
            <div class="mb-6 flex gap-2">
                <a href="{{ route('stats.index', ['view' => 'day', 'date' => $currentDate->format('Y-m-d')]) }}"
                   class="flex-1 px-4 py-3 rounded-xl font-medium text-center transition-colors {{ $view === 'day' ? 'bg-accent text-white' : 'bg-white dark:bg-dark-card text-gray-900 dark:text-white border border-gray-200 dark:border-[#2a2d45]' }}">
                    Day
                </a>
                <a href="{{ route('stats.index', ['view' => 'week', 'date' => $currentDate->format('Y-m-d')]) }}"
                   class="flex-1 px-4 py-3 rounded-xl font-medium text-center transition-colors {{ $view === 'week' ? 'bg-accent text-white' : 'bg-white dark:bg-dark-card text-gray-900 dark:text-white border border-gray-200 dark:border-[#2a2d45]' }}">
                    Week
                </a>
                <a href="{{ route('stats.index', ['view' => 'month', 'date' => $currentDate->format('Y-m-d')]) }}"
                   class="flex-1 px-4 py-3 rounded-xl font-medium text-center transition-colors {{ $view === 'month' ? 'bg-accent text-white' : 'bg-white dark:bg-dark-card text-gray-900 dark:text-white border border-gray-200 dark:border-[#2a2d45]' }}">
                    Month
                </a>
            </div>

            {{-- Date Navigation --}}
            <div class="mb-6 flex items-center justify-between bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-[#2a2d45] p-4">
                <a href="{{ route('stats.index', ['view' => $view, 'date' => $currentDate->copy()->sub(1, $view)->format('Y-m-d')]) }}"
                   class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-[#2a2d45] transition-colors">
                    <svg class="w-6 h-6 text-gray-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>

                <div class="text-center">
                    @if($view === 'day')
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ $currentDate->format('M d, Y') }}</h2>
                        <p class="text-sm text-gray-500 dark:text-text-muted">{{ $currentDate->format('l') }}</p>
                    @elseif($view === 'week')
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['start_date']->format('M d') }} - {{ $stats['end_date']->format('M d, Y') }}</h2>
                        <p class="text-sm text-gray-500 dark:text-text-muted">Week {{ $currentDate->weekOfYear }}</p>
                    @else
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['month_name'] }}</h2>
                        <p class="text-sm text-gray-500 dark:text-text-muted">{{ $stats['daily_data'] ? count($stats['daily_data']) : 0 }} days</p>
                    @endif
                </div>

                <a href="{{ route('stats.index', ['view' => $view, 'date' => $currentDate->copy()->add(1, $view)->format('Y-m-d')]) }}"
                   class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-[#2a2d45] transition-colors {{ $currentDate->copy()->add(1, $view)->isFuture() ? 'opacity-50 pointer-events-none' : '' }}">
                    <svg class="w-6 h-6 text-gray-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            @if($view === 'day')
                {{-- Daily View --}}
                <div class="space-y-4">
                    <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-[#2a2d45] p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Summary</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-text-muted mb-1">Total Intake</p>
                                <p class="text-3xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_ml'] }} <span class="text-lg text-gray-500 dark:text-text-secondary">ml</span></p>
                                <div class="mt-2 w-full bg-gray-200 dark:bg-dark-bg rounded-full h-2">
                                    <div class="h-2 rounded-full {{ $stats['total_ml'] >= $dailyTarget ? 'bg-[#a8d5a8]' : 'bg-accent' }}"
                                         style="width: {{ min(100, ($stats['total_ml'] / $dailyTarget) * 100) }}%">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-text-muted mb-1">Total Feeds</p>
                                <p class="text-3xl font-semibold text-gray-900 dark:text-white">{{ $stats['feed_count'] }}</p>
                            </div>
                        </div>

                        @if($stats['by_type']->count() > 0)
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-[#2a2d45]">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-text-secondary mb-3">By Type</h4>
                                <div class="space-y-2">
                                    @foreach($stats['by_type'] as $type => $data)
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
                                            <span class="text-sm font-medium text-gray-600 dark:text-text-secondary">{{ $data['count'] }} feeds, {{ $data['total_ml'] }} ml</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($stats['feeds']->count() > 0)
                        <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-[#2a2d45] p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Feed Timeline</h3>
                            <div class="space-y-3">
                                @foreach($stats['feeds'] as $feed)
                                    <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 dark:bg-dark-bg">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $feed->start_time->format('h:i A') }}
                                        </div>
                                        <div class="flex-1">
                                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                                {{ $feed->type === 'breast_left' || $feed->type === 'breast_right' ? 'bg-breast text-[#8b5a9b]' : '' }}
                                                {{ $feed->type === 'bottle' ? 'bg-bottle text-[#5a8bb8]' : '' }}
                                                {{ $feed->type === 'formula' ? 'bg-formula text-[#b8945a]' : '' }}">
                                                {{ ucfirst(str_replace('_', ' ', $feed->type)) }}
                                            </span>
                                        </div>
                                        <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $feed->quantity_ml }} ml
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

            @elseif($view === 'week')
                {{-- Weekly View --}}
                <div class="space-y-4">
                    <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-[#2a2d45] p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Week Total</h3>
                        <p class="text-4xl font-semibold text-gray-900 dark:text-white">{{ $stats['week_total'] }} <span class="text-lg text-gray-500 dark:text-text-secondary">ml</span></p>
                        <p class="text-sm text-gray-500 dark:text-text-muted mt-1">Average: {{ $stats['week_total'] > 0 ? round($stats['week_total'] / 7) : 0 }} ml/day</p>
                    </div>

                    <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-[#2a2d45] p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Daily Breakdown</h3>
                        <div class="space-y-3">
                            @foreach($stats['daily_data'] as $day)
                                <div class="flex items-center gap-3">
                                    <div class="w-16 text-sm {{ $day['is_today'] ? 'font-semibold text-accent' : 'text-gray-600 dark:text-text-secondary' }}">
                                        {{ $day['date']->format('D') }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="h-8 bg-gray-100 dark:bg-dark-bg rounded-lg overflow-hidden">
                                            <div class="h-full {{ $day['total_ml'] >= $dailyTarget ? 'bg-[#a8d5a8]' : 'bg-accent' }} transition-all"
                                                 style="width: {{ min(100, ($day['total_ml'] / $dailyTarget) * 100) }}%">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-20 text-right">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $day['total_ml'] }} ml</span>
                                        <span class="text-xs text-gray-500 dark:text-text-muted block">{{ $day['feed_count'] }} feeds</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            @else
                {{-- Monthly View --}}
                <div class="space-y-4">
                    <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-[#2a2d45] p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Month Total</h3>
                        <p class="text-4xl font-semibold text-gray-900 dark:text-white">{{ $stats['month_total'] }} <span class="text-lg text-gray-500 dark:text-text-secondary">ml</span></p>
                        <p class="text-sm text-gray-500 dark:text-text-muted mt-1">Average: {{ $stats['month_total'] > 0 ? round($stats['month_total'] / count($stats['daily_data'])) : 0 }} ml/day</p>
                    </div>

                    <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-[#2a2d45] p-4 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-5">Calendar</h3>

                        {{-- Calendar Grid --}}
                        <div class="grid grid-cols-7 gap-1.5 sm:gap-2">
                            {{-- Day Headers --}}
                            <div class="text-xs text-center text-gray-500 dark:text-text-muted font-semibold py-2 border-b border-gray-200 dark:border-[#2a2d45]">Sun</div>
                            <div class="text-xs text-center text-gray-500 dark:text-text-muted font-semibold py-2 border-b border-gray-200 dark:border-[#2a2d45]">Mon</div>
                            <div class="text-xs text-center text-gray-500 dark:text-text-muted font-semibold py-2 border-b border-gray-200 dark:border-[#2a2d45]">Tue</div>
                            <div class="text-xs text-center text-gray-500 dark:text-text-muted font-semibold py-2 border-b border-gray-200 dark:border-[#2a2d45]">Wed</div>
                            <div class="text-xs text-center text-gray-500 dark:text-text-muted font-semibold py-2 border-b border-gray-200 dark:border-[#2a2d45]">Thu</div>
                            <div class="text-xs text-center text-gray-500 dark:text-text-muted font-semibold py-2 border-b border-gray-200 dark:border-[#2a2d45]">Fri</div>
                            <div class="text-xs text-center text-gray-500 dark:text-text-muted font-semibold py-2 border-b border-gray-200 dark:border-[#2a2d45]">Sat</div>

                            @php
                                $firstDayOfWeek = $stats['start_date']->dayOfWeek;
                            @endphp

                            {{-- Empty cells before month starts --}}
                            @for($i = 0; $i < $firstDayOfWeek; $i++)
                                <div class="aspect-square"></div>
                            @endfor

                            {{-- Calendar days --}}
                            @foreach($stats['daily_data'] as $day)
                                <div class="aspect-square">
                                    <div class="h-full rounded-lg p-1.5 sm:p-2 flex flex-col items-center justify-start border transition-all
                                        {{ $day['is_today']
                                            ? 'bg-accent border-accent text-white shadow-md'
                                            : ($day['total_ml'] >= $dailyTarget
                                                ? 'bg-[#a8d5a8] border-[#90c690] text-white'
                                                : ($day['total_ml'] > 0
                                                    ? 'bg-gray-50 dark:bg-[#1a1c2e] border-gray-200 dark:border-[#2a2d45] text-gray-900 dark:text-white'
                                                    : 'bg-transparent border-gray-100 dark:border-[#2a2d45] text-gray-400 dark:text-text-muted')) }}">

                                        {{-- Day number --}}
                                        <div class="text-sm font-semibold mb-0.5">{{ $day['date']->format('j') }}</div>

                                        {{-- Feed data --}}
                                        @if($day['total_ml'] > 0)
                                            <div class="flex flex-col items-center gap-0.5 mt-auto w-full">
                                                <div class="text-[10px] font-medium opacity-90">{{ $day['total_ml'] }}ml</div>
                                                @if($day['feed_count'] > 0)
                                                    <div class="w-full flex justify-center gap-0.5">
                                                        @for($i = 0; $i < min(3, $day['feed_count']); $i++)
                                                            <div class="w-1 h-1 rounded-full {{ $day['is_today'] ? 'bg-white' : ($day['total_ml'] >= $dailyTarget ? 'bg-white' : 'bg-gray-400 dark:bg-gray-500') }}"></div>
                                                        @endfor
                                                        @if($day['feed_count'] > 3)
                                                            <div class="text-[8px] opacity-75">+</div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Calendar Legend --}}
                        <div class="mt-5 pt-5 border-t border-gray-200 dark:border-[#2a2d45]">
                            <div class="flex flex-wrap gap-3 text-xs">
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded bg-accent"></div>
                                    <span class="text-gray-600 dark:text-text-secondary">Today</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded bg-[#a8d5a8]"></div>
                                    <span class="text-gray-600 dark:text-text-secondary">Target met</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded bg-gray-50 dark:bg-[#1a1c2e] border border-gray-200 dark:border-[#2a2d45]"></div>
                                    <span class="text-gray-600 dark:text-text-secondary">Has data</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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
