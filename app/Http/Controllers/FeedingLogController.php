<?php

namespace App\Http\Controllers;

use App\Models\FeedingLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class FeedingLogController extends Controller
{
    public function index()
    {
        $feedingLogs = FeedingLog::orderBy('start_time', 'desc')
            ->take(50)
            ->get();

        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();

        $todayTotal = FeedingLog::whereBetween('start_time', [$todayStart, $todayEnd])
            ->sum('quantity_ml');

        $dailyTarget = \App\Models\Setting::get('daily_target_ml', 700);

        return view('dashboard', compact('feedingLogs', 'todayTotal', 'dailyTarget'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:breast_left,breast_right,bottle,formula',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'quantity_ml' => 'required|integer|min:1|max:300',
            'notes' => 'nullable|string',
        ]);

        $feedingLog = FeedingLog::create($validated);

        if ($request->expectsJson()) {
            return response()->json($feedingLog, 201);
        }

        return redirect()->route('feeding-logs.index')
            ->with('success', 'Feed logged successfully!');
    }

    public function update(Request $request, FeedingLog $feedingLog)
    {
        $validated = $request->validate([
            'type' => 'required|in:breast_left,breast_right,bottle,formula',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'quantity_ml' => 'required|integer|min:1|max:300',
            'notes' => 'nullable|string',
        ]);

        $feedingLog->update($validated);

        if ($request->expectsJson()) {
            return response()->json($feedingLog);
        }

        return redirect()->route('feeding-logs.index')
            ->with('success', 'Feed updated successfully!');
    }

    public function destroy(FeedingLog $feedingLog)
    {
        $feedingLog->delete();

        if (request()->expectsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('feeding-logs.index')
            ->with('success', 'Feed deleted successfully!');
    }

    public function export(Request $request)
    {
        $format = $request->query('format', 'csv');
        $feedingLogs = FeedingLog::orderBy('start_time', 'desc')->get();

        if ($format === 'json') {
            return response()->json($feedingLogs);
        }

        $csv = "ID,Type,Start Time,End Time,Duration (min),Quantity (ml),Notes,Created At\n";

        foreach ($feedingLogs as $log) {
            $csv .= implode(',', [
                $log->id,
                $log->type,
                $log->start_time->format('Y-m-d H:i:s'),
                $log->end_time ? $log->end_time->format('Y-m-d H:i:s') : '',
                $log->duration_minutes ?? '',
                $log->quantity_ml ?? '',
                '"' . str_replace('"', '""', $log->notes ?? '') . '"',
                $log->created_at->format('Y-m-d H:i:s'),
            ]) . "\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="feeding-logs-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
}
