<?php

namespace App\Http\Controllers;

use App\Models\FeedingLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $timezone = Setting::get('timezone', 'Asia/Kolkata');
        config(['app.timezone' => $timezone]);

        $view = $request->query('view', 'week'); // day, week, month
        $date = $request->query('date', now()->format('Y-m-d'));

        $currentDate = Carbon::parse($date);

        if ($view === 'day') {
            $stats = $this->getDailyStats($currentDate);
        } elseif ($view === 'week') {
            $stats = $this->getWeeklyStats($currentDate);
        } else {
            $stats = $this->getMonthlyStats($currentDate);
        }

        $dailyTarget = Setting::get('daily_target_ml', 700);

        return view('stats', compact('stats', 'view', 'currentDate', 'dailyTarget'));
    }

    private function getDailyStats(Carbon $date)
    {
        $start = $date->copy()->startOfDay();
        $end = $date->copy()->endOfDay();

        $feeds = FeedingLog::whereBetween('start_time', [$start, $end])
            ->orderBy('start_time', 'asc')
            ->get();

        $totalMl = $feeds->sum('quantity_ml');
        $feedCount = $feeds->count();

        $byType = $feeds->groupBy('type')->map(function ($items) {
            return [
                'count' => $items->count(),
                'total_ml' => $items->sum('quantity_ml'),
            ];
        });

        return [
            'date' => $date,
            'feeds' => $feeds,
            'total_ml' => $totalMl,
            'feed_count' => $feedCount,
            'by_type' => $byType,
        ];
    }

    private function getWeeklyStats(Carbon $date)
    {
        $start = $date->copy()->startOfWeek();
        $end = $date->copy()->endOfWeek();

        $dailyData = [];
        for ($day = $start->copy(); $day->lte($end); $day->addDay()) {
            $dayStart = $day->copy()->startOfDay();
            $dayEnd = $day->copy()->endOfDay();

            $dayTotal = FeedingLog::whereBetween('start_time', [$dayStart, $dayEnd])
                ->sum('quantity_ml');

            $dayCount = FeedingLog::whereBetween('start_time', [$dayStart, $dayEnd])
                ->count();

            $dailyData[] = [
                'date' => $day->copy(),
                'total_ml' => $dayTotal,
                'feed_count' => $dayCount,
                'is_today' => $day->isToday(),
            ];
        }

        $weekTotal = FeedingLog::whereBetween('start_time', [$start, $end])
            ->sum('quantity_ml');

        return [
            'start_date' => $start,
            'end_date' => $end,
            'daily_data' => $dailyData,
            'week_total' => $weekTotal,
        ];
    }

    private function getMonthlyStats(Carbon $date)
    {
        $start = $date->copy()->startOfMonth();
        $end = $date->copy()->endOfMonth();

        $dailyData = [];
        for ($day = $start->copy(); $day->lte($end); $day->addDay()) {
            $dayStart = $day->copy()->startOfDay();
            $dayEnd = $day->copy()->endOfDay();

            $dayTotal = FeedingLog::whereBetween('start_time', [$dayStart, $dayEnd])
                ->sum('quantity_ml');

            $dayCount = FeedingLog::whereBetween('start_time', [$dayStart, $dayEnd])
                ->count();

            $dailyData[] = [
                'date' => $day->copy(),
                'total_ml' => $dayTotal,
                'feed_count' => $dayCount,
                'is_today' => $day->isToday(),
                'day_of_week' => $day->dayOfWeek,
            ];
        }

        $monthTotal = FeedingLog::whereBetween('start_time', [$start, $end])
            ->sum('quantity_ml');

        return [
            'month_name' => $start->format('F Y'),
            'start_date' => $start,
            'end_date' => $end,
            'daily_data' => $dailyData,
            'month_total' => $monthTotal,
        ];
    }
}
