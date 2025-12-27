<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>nextFeed - Baby Feeding Tracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-[#171923]">
    <div id="app" class="min-h-screen pb-32">
        <div class="max-w-2xl mx-auto px-4 py-6">
            <header class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">nextFeed</h1>
                <div class="flex gap-3">
                    <a href="{{ route('stats.index') }}" class="p-3 rounded-xl bg-gray-200 dark:bg-[#22243b] text-gray-800 dark:text-[#bfcbe6] hover:bg-gray-300 dark:hover:bg-[#2a2d45] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </a>
                    <a href="{{ route('settings.index') }}" class="p-3 rounded-xl bg-gray-200 dark:bg-[#22243b] text-gray-800 dark:text-[#bfcbe6] hover:bg-gray-300 dark:hover:bg-[#2a2d45] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </a>
                    <button onclick="toggleDarkMode()" class="p-3 rounded-xl bg-gray-200 dark:bg-[#22243b] text-gray-800 dark:text-[#bfcbe6] hover:bg-gray-300 dark:hover:bg-[#2a2d45] transition-colors">
                        <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                        <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </button>
                    <a href="{{ route('feeding-logs.export') }}?format=csv" class="p-3 rounded-xl bg-[#e17d92] hover:bg-[#d16880] text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

            <div class="mb-6 p-6 bg-white dark:bg-[#22243b] rounded-2xl border border-gray-200 dark:border-[#2a2d45]">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Today's Intake</h2>
                    <span class="text-sm text-gray-500 dark:text-[#7b8390]">{{ now()->format('M d, Y') }}</span>
                </div>

                <div class="flex items-end gap-2 mb-4">
                    <span class="text-4xl font-semibold text-gray-900 dark:text-white">{{ $todayTotal }}</span>
                    <span class="text-2xl text-gray-500 dark:text-[#bfcbe6] mb-1">/ {{ $dailyTarget }} ml</span>
                </div>

                <div class="w-full bg-gray-200 dark:bg-[#171923] rounded-full h-3 mb-3">
                    <div class="h-3 rounded-full transition-all duration-500 {{ $todayTotal >= $dailyTarget ? 'bg-[#a8d5a8]' : ($todayTotal >= $dailyTarget * 0.7 ? 'bg-[#daeaf6]' : 'bg-[#fff7e6]') }}"
                         style="width: {{ min(100, ($todayTotal / $dailyTarget) * 100) }}%">
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-[#bfcbe6]">
                        @if($todayTotal >= $dailyTarget)
                            <span class="text-[#a8d5a8] font-medium">✓ Target reached!</span>
                        @else
                            <span class="text-gray-700 dark:text-[#bfcbe6]">{{ $dailyTarget - $todayTotal }} ml remaining</span>
                        @endif
                    </span>
                    <span class="text-gray-600 dark:text-[#7b8390]">{{ round(($todayTotal / $dailyTarget) * 100) }}%</span>
                </div>
            </div>

            <div class="mb-6">
                <div id="nextFeedReminder" class="p-5 bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-[#2a2d45]">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm text-gray-600 dark:text-text-muted">Next feed in</p>
                            <p id="nextFeedTime" class="text-2xl font-medium text-gray-900 dark:text-white mb-1">--</p>
                            <p id="nextFeedActualTime" class="text-sm text-gray-500 dark:text-text-muted">--</p>
                        </div>
                        <button onclick="openQuickLogModal()" class="px-6 py-3 bg-accent hover:bg-accent-hover text-white rounded-xl font-medium transition-colors">
                            Log Feed
                        </button>
                    </div>
                </div>
            </div>

            <div class="space-y-3 mb-6">
                @forelse($feedingLogs as $log)
                    <div class="p-5 bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-[#2a2d45]">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="px-4 py-2 text-3xl font-semibold text-gray-900 dark:text-white">
                                        {{ $log->quantity_ml }} <span class="text-lg text-gray-500 dark:text-text-secondary">ml</span>
                                    </span>
                                    <div class="flex flex-col">
                                        <span class="px-3 py-1 text-sm font-medium rounded-full
                                            {{ $log->type === 'breast_left' || $log->type === 'breast_right' ? 'bg-[#efd9f4] text-[#8b5a9b] dark:bg-[#efd9f4]/20 dark:text-[#efd9f4]' : '' }}
                                            {{ $log->type === 'bottle' ? 'bg-[#daeaf6] text-[#5a8bb8] dark:bg-[#daeaf6]/20 dark:text-[#daeaf6]' : '' }}
                                            {{ $log->type === 'formula' ? 'bg-[#fff7e6] text-[#b8945a] dark:bg-[#fff7e6]/20 dark:text-[#fff7e6]' : '' }}">
                                            {{ ucfirst(str_replace('_', ' ', $log->type)) }}
                                        </span>
                                        <span class="text-sm text-gray-500 dark:text-text-muted mt-1">
                                            {{ $log->start_time->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-text-secondary">
                                    {{ $log->start_time->format('M d, Y h:i A') }}
                                    @if($log->end_time)
                                        - {{ $log->end_time->format('h:i A') }}
                                        <span class="text-sm">({{ $log->duration_minutes }} min)</span>
                                    @endif
                                </p>
                                @if($log->notes)
                                    <p class="text-sm text-gray-600 dark:text-text-secondary mt-1">
                                        {{ $log->notes }}
                                    </p>
                                @endif
                            </div>
                            <div class="flex gap-2 ml-4">
                                <button onclick="editLog({{ $log->id }}, '{{ $log->type }}', '{{ $log->start_time->format('Y-m-d\TH:i') }}', '{{ $log->end_time ? $log->end_time->format('Y-m-d\TH:i') : '' }}', {{ $log->quantity_ml }}, {{ json_encode($log->notes) }})" class="p-2 text-gray-600 dark:text-text-secondary hover:bg-gray-100 dark:hover:bg-[#2a2d45] rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="deleteLog({{ $log->id }})" class="p-2 text-[#f56565] hover:bg-[#f56565]/10 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-[#2a2d45]">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <p class="text-gray-600 dark:text-text-secondary mb-2">No feeds logged yet</p>
                        <p class="text-sm text-gray-500 dark:text-text-muted">Tap the button below to log your first feed</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="fixed bottom-0 left-0 right-0 bg-white dark:bg-dark-card border-t border-gray-200 dark:border-[#2a2d45]">
            <div class="max-w-2xl mx-auto p-5">
                <div id="feedingControls">
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <button onclick="quickLog('breast_left')" class="feed-button bg-breast hover:bg-breast-hover text-[#8b5a9b] p-5 rounded-2xl font-medium text-lg active:scale-95 transition-all">
                            Left Breast
                        </button>
                        <button onclick="quickLog('breast_right')" class="feed-button bg-breast hover:bg-breast-hover text-[#8b5a9b] p-5 rounded-2xl font-medium text-lg active:scale-95 transition-all">
                            Right Breast
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="quickLog('bottle')" class="feed-button bg-bottle hover:bg-bottle-hover text-[#5a8bb8] p-5 rounded-2xl font-medium text-lg active:scale-95 transition-all">
                            Bottle
                        </button>
                        <button onclick="quickLog('formula')" class="feed-button bg-formula hover:bg-formula-hover text-[#b8945a] p-5 rounded-2xl font-medium text-lg active:scale-95 transition-all">
                            Formula
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="quantityModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50" onclick="if(event.target === this) closeModal()">
            <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-dark-card rounded-2xl p-8 max-w-md w-full shadow-2xl border border-gray-200 dark:border-[#2a2d45]">
                <h3 class="text-2xl font-medium text-gray-900 dark:text-white mb-6">How much milk?</h3>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-text-secondary mb-3">
                        Quantity (ml)
                    </label>
                    <input
                        type="number"
                        id="quantityInput"
                        min="1"
                        max="300"
                        step="5"
                        class="w-full px-4 py-4 text-3xl font-semibold text-center rounded-xl border-2 border-gray-300 dark:border-[#2a2d45] bg-white dark:bg-[#171923] text-gray-900 dark:text-white focus:ring-2 focus:ring-accent focus:border-transparent transition-all"
                        placeholder="60"
                        autofocus
                    >
                    <div class="grid grid-cols-4 gap-2 mt-4">
                        <button onclick="setQuantity(30)" class="px-4 py-3 bg-gray-100 dark:bg-[#171923] text-gray-900 dark:text-text-secondary rounded-xl hover:bg-gray-200 dark:hover:bg-[#22243b] font-medium transition-colors">30</button>
                        <button onclick="setQuantity(60)" class="px-4 py-3 bg-gray-100 dark:bg-[#171923] text-gray-900 dark:text-text-secondary rounded-xl hover:bg-gray-200 dark:hover:bg-[#22243b] font-medium transition-colors">60</button>
                        <button onclick="setQuantity(90)" class="px-4 py-3 bg-gray-100 dark:bg-[#171923] text-gray-900 dark:text-text-secondary rounded-xl hover:bg-gray-200 dark:hover:bg-[#22243b] font-medium transition-colors">90</button>
                        <button onclick="setQuantity(120)" class="px-4 py-3 bg-gray-100 dark:bg-[#171923] text-gray-900 dark:text-text-secondary rounded-xl hover:bg-gray-200 dark:hover:bg-[#22243b] font-medium transition-colors">120</button>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button onclick="closeModal()" class="flex-1 px-6 py-3 bg-gray-200 dark:bg-[#171923] text-gray-900 dark:text-text-secondary font-medium rounded-xl hover:bg-gray-300 dark:hover:bg-[#22243b] transition-colors">
                        Cancel
                    </button>
                    <button onclick="submitFeed()" class="flex-1 px-6 py-3 bg-accent hover:bg-accent-hover text-white font-medium rounded-xl transition-colors">
                        Save
                    </button>
                </div>
            </div>
            </div>
        </div>

        <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50" onclick="if(event.target === this) closeEditModal()">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white dark:bg-dark-card rounded-2xl p-8 max-w-md w-full shadow-2xl border border-gray-200 dark:border-[#2a2d45] max-h-[90vh] overflow-y-auto">
                    <h3 class="text-2xl font-medium text-gray-900 dark:text-white mb-6">Edit Feed</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-text-secondary mb-2">
                                Feed Type
                            </label>
                            <select id="editType" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#2a2d45] bg-white dark:bg-[#171923] text-gray-900 dark:text-white focus:ring-2 focus:ring-accent focus:border-transparent transition-all">
                                <option value="breast_left">Left Breast</option>
                                <option value="breast_right">Right Breast</option>
                                <option value="bottle">Bottle</option>
                                <option value="formula">Formula</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-text-secondary mb-2">
                                Start Time
                            </label>
                            <input type="datetime-local" id="editStartTime" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#2a2d45] bg-white dark:bg-[#171923] text-gray-900 dark:text-white focus:ring-2 focus:ring-accent focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-text-secondary mb-2">
                                End Time (optional)
                            </label>
                            <input type="datetime-local" id="editEndTime" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#2a2d45] bg-white dark:bg-[#171923] text-gray-900 dark:text-white focus:ring-2 focus:ring-accent focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-text-secondary mb-2">
                                Quantity (ml)
                            </label>
                            <input type="number" id="editQuantity" min="1" max="300" step="5" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#2a2d45] bg-white dark:bg-[#171923] text-gray-900 dark:text-white focus:ring-2 focus:ring-accent focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-text-secondary mb-2">
                                Notes (optional)
                            </label>
                            <textarea id="editNotes" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#2a2d45] bg-white dark:bg-[#171923] text-gray-900 dark:text-white focus:ring-2 focus:ring-accent focus:border-transparent transition-all"></textarea>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button onclick="closeEditModal()" class="flex-1 px-6 py-3 bg-gray-200 dark:bg-[#171923] text-gray-900 dark:text-text-secondary font-medium rounded-xl hover:bg-gray-300 dark:hover:bg-[#22243b] transition-colors">
                            Cancel
                        </button>
                        <button onclick="submitEdit()" class="flex-1 px-6 py-3 bg-accent hover:bg-accent-hover text-white font-medium rounded-xl transition-colors">
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedFeedType = null;
        let editingLogId = null;

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

        function editLog(id, type, startTime, endTime, quantity, notes) {
            editingLogId = id;
            document.getElementById('editType').value = type;
            document.getElementById('editStartTime').value = startTime;
            document.getElementById('editEndTime').value = endTime || '';
            document.getElementById('editQuantity').value = quantity;
            document.getElementById('editNotes').value = notes || '';
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            editingLogId = null;
        }

        function submitEdit() {
            const type = document.getElementById('editType').value;
            const startTime = document.getElementById('editStartTime').value;
            const endTime = document.getElementById('editEndTime').value;
            const quantity = parseInt(document.getElementById('editQuantity').value);
            const notes = document.getElementById('editNotes').value;

            if (!startTime) {
                alert('Please enter a start time');
                return;
            }

            if (!quantity || quantity < 1 || quantity > 300) {
                alert('Please enter a valid quantity between 1 and 300 ml');
                return;
            }

            if (endTime && endTime <= startTime) {
                alert('End time must be after start time');
                return;
            }

            const data = {
                type: type,
                start_time: startTime.replace('T', ' ') + ':00',
                quantity_ml: quantity,
                notes: notes || null
            };

            if (endTime) {
                data.end_time = endTime.replace('T', ' ') + ':00';
            }

            fetch(`/feeding-logs/${editingLogId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
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
                alert('Failed to update feed. Please check your inputs and try again.');
            });
        }

        function updateNextFeedTime() {
            const lastFeed = @json($feedingLogs->first());
            const reminderIntervalMinutes = {{ $reminderInterval }};

            if (!lastFeed) {
                document.getElementById('nextFeedTime').textContent = 'No feeds yet';
                document.getElementById('nextFeedActualTime').textContent = '';
                return;
            }

            const lastFeedTime = new Date(lastFeed.start_time);
            const reminderInterval = reminderIntervalMinutes * 60 * 1000;
            const nextFeedTime = new Date(lastFeedTime.getTime() + reminderInterval);
            const now = new Date();
            const diff = nextFeedTime - now;

            // Format the actual time
            const timeOptions = {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            };
            const actualTimeText = nextFeedTime.toLocaleTimeString('en-US', timeOptions);

            if (diff < 0) {
                document.getElementById('nextFeedTime').textContent = 'Overdue';
                document.getElementById('nextFeedActualTime').textContent = `was due at ${actualTimeText}`;
                document.getElementById('nextFeedReminder').classList.add('border-[#f56565]');
            } else {
                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                document.getElementById('nextFeedTime').textContent = `${hours}h ${minutes}m`;
                document.getElementById('nextFeedActualTime').textContent = `at ${actualTimeText}`;
            }
        }

        updateNextFeedTime();
        setInterval(updateNextFeedTime, 60000);
    </script>
</body>
</html>
