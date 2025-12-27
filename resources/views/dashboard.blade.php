<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>nextFeed - Baby Feeding Tracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div id="app" class="min-h-screen pb-32">
        <div class="max-w-2xl mx-auto px-4 py-6">
            <header class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">nextFeed</h1>
                <div class="flex gap-2">
                    <a href="{{ route('settings.index') }}" class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </a>
                    <button onclick="toggleDarkMode()" class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <svg class="w-6 h-6 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                        <svg class="w-6 h-6 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </button>
                    <a href="{{ route('feeding-logs.export') }}?format=csv" class="p-2 rounded-lg bg-blue-600 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </a>
                </div>
            </header>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 p-6 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border-2 border-blue-200 dark:border-blue-800">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Today's Intake</h2>
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ now()->format('M d, Y') }}</span>
                </div>

                <div class="flex items-end gap-2 mb-3">
                    <span class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $todayTotal }}</span>
                    <span class="text-2xl text-gray-600 dark:text-gray-400 mb-1">/ {{ $dailyTarget }} ml</span>
                </div>

                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 mb-2">
                    <div class="h-4 rounded-full transition-all duration-500 {{ $todayTotal >= $dailyTarget ? 'bg-green-500' : ($todayTotal >= $dailyTarget * 0.7 ? 'bg-blue-500' : 'bg-amber-500') }}"
                         style="width: {{ min(100, ($todayTotal / $dailyTarget) * 100) }}%">
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">
                        @if($todayTotal >= $dailyTarget)
                            <span class="text-green-600 dark:text-green-400 font-semibold">✓ Target reached!</span>
                        @else
                            <span class="text-gray-700 dark:text-gray-300">{{ $dailyTarget - $todayTotal }} ml remaining</span>
                        @endif
                    </span>
                    <span class="text-gray-600 dark:text-gray-400">{{ round(($todayTotal / $dailyTarget) * 100) }}%</span>
                </div>
            </div>

            <div class="mb-6">
                <div id="nextFeedReminder" class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-blue-800 dark:text-blue-200">Next feed in</p>
                            <p id="nextFeedTime" class="text-2xl font-bold text-blue-900 dark:text-blue-100">--</p>
                        </div>
                        <button onclick="openQuickLogModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold">
                            Log Feed
                        </button>
                    </div>
                </div>
            </div>

            <div class="space-y-4 mb-6">
                @forelse($feedingLogs as $log)
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="px-4 py-2 text-3xl font-bold text-blue-600 dark:text-blue-400">
                                        {{ $log->quantity_ml }} <span class="text-lg text-gray-600 dark:text-gray-400">ml</span>
                                    </span>
                                    <div class="flex flex-col">
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full
                                            {{ $log->type === 'breast_left' ? 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200' : '' }}
                                            {{ $log->type === 'breast_right' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : '' }}
                                            {{ $log->type === 'bottle' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                            {{ $log->type === 'formula' ? 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200' : '' }}">
                                            {{ ucfirst(str_replace('_', ' ', $log->type)) }}
                                        </span>
                                        <span class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            {{ $log->start_time->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $log->start_time->format('M d, Y h:i A') }}
                                    @if($log->end_time)
                                        - {{ $log->end_time->format('h:i A') }}
                                        <span class="text-sm">({{ $log->duration_minutes }} min)</span>
                                    @endif
                                </p>
                                @if($log->notes)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        {{ $log->notes }}
                                    </p>
                                @endif
                            </div>
                            <button onclick="deleteLog({{ $log->id }})" class="ml-4 p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <p class="text-gray-600 dark:text-gray-400 mb-2">No feeds logged yet</p>
                        <p class="text-sm text-gray-500 dark:text-gray-500">Tap the button below to log your first feed</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-lg">
            <div class="max-w-2xl mx-auto p-4">
                <div id="feedingControls">
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <button onclick="quickLog('breast_left')" class="feed-button bg-pink-600 hover:bg-pink-700 text-white p-4 rounded-xl font-semibold text-lg shadow-lg active:scale-95 transition-transform">
                            Left Breast
                        </button>
                        <button onclick="quickLog('breast_right')" class="feed-button bg-purple-600 hover:bg-purple-700 text-white p-4 rounded-xl font-semibold text-lg shadow-lg active:scale-95 transition-transform">
                            Right Breast
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="quickLog('bottle')" class="feed-button bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-xl font-semibold text-lg shadow-lg active:scale-95 transition-transform">
                            Bottle
                        </button>
                        <button onclick="quickLog('formula')" class="feed-button bg-amber-600 hover:bg-amber-700 text-white p-4 rounded-xl font-semibold text-lg shadow-lg active:scale-95 transition-transform">
                            Formula
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="quantityModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50" onclick="if(event.target === this) closeModal()">
            <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">How much milk?</h3>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Quantity (ml)
                    </label>
                    <input
                        type="number"
                        id="quantityInput"
                        min="1"
                        max="300"
                        step="5"
                        class="w-full px-4 py-4 text-3xl font-bold text-center rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="60"
                        autofocus
                    >
                    <div class="grid grid-cols-4 gap-2 mt-4">
                        <button onclick="setQuantity(30)" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">30</button>
                        <button onclick="setQuantity(60)" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">60</button>
                        <button onclick="setQuantity(90)" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">90</button>
                        <button onclick="setQuantity(120)" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">120</button>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button onclick="closeModal()" class="flex-1 px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600">
                        Cancel
                    </button>
                    <button onclick="submitFeed()" class="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700">
                        Save
                    </button>
                </div>
            </div>
            </div>
        </div>
    </div>

    <script>
        let selectedFeedType = null;

        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }

        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }

        function quickLog(type) {
            selectedFeedType = type;
            document.getElementById('quantityModal').classList.remove('hidden');
            document.getElementById('quantityInput').value = '';
            document.getElementById('quantityInput').focus();
        }

        function openQuickLogModal() {
            const lastFeedType = '{{ $feedingLogs->first()->type ?? 'breast_left' }}';
            quickLog(lastFeedType);
        }

        function closeModal() {
            document.getElementById('quantityModal').classList.add('hidden');
            selectedFeedType = null;
        }

        function setQuantity(amount) {
            document.getElementById('quantityInput').value = amount;
        }

        function submitFeed() {
            const quantity = parseInt(document.getElementById('quantityInput').value);

            if (!quantity || quantity < 1 || quantity > 300) {
                alert('Please enter a valid quantity between 1 and 300 ml');
                return;
            }

            const now = new Date().toISOString().slice(0, 19).replace('T', ' ');

            fetch('{{ route('feeding-logs.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    type: selectedFeedType,
                    start_time: now,
                    quantity_ml: quantity
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to log feed. Please enter quantity.');
            });
        }

        document.getElementById('quantityInput')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                submitFeed();
            }
        });

        function deleteLog(id) {
            if (!confirm('Are you sure you want to delete this feed log?')) {
                return;
            }

            fetch(`/feeding-logs/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(() => {
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete feed. Please try again.');
            });
        }

        function updateNextFeedTime() {
            const lastFeed = @json($feedingLogs->first());

            if (!lastFeed) {
                document.getElementById('nextFeedTime').textContent = 'No feeds yet';
                return;
            }

            const lastFeedTime = new Date(lastFeed.start_time);
            const reminderInterval = 3 * 60 * 60 * 1000;
            const nextFeedTime = new Date(lastFeedTime.getTime() + reminderInterval);
            const now = new Date();
            const diff = nextFeedTime - now;

            if (diff < 0) {
                document.getElementById('nextFeedTime').textContent = 'Overdue';
                document.getElementById('nextFeedReminder').classList.add('bg-red-50', 'dark:bg-red-900/20', 'border-red-200', 'dark:border-red-800');
                document.getElementById('nextFeedReminder').classList.remove('bg-blue-50', 'dark:bg-blue-900/20', 'border-blue-200', 'dark:border-blue-800');
            } else {
                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                document.getElementById('nextFeedTime').textContent = `${hours}h ${minutes}m`;
            }
        }

        updateNextFeedTime();
        setInterval(updateNextFeedTime, 60000);
    </script>
</body>
</html>
