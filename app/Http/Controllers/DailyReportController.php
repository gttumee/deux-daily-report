<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function create()
    {
        return view('daily_report');
    }

    public function store(Request $request)
    {
        $reportDate = $request->input('report_date');
        $tasks = $request->input('tasks');
    
        $report = DailyReport::create([
            'user_id' => auth()->id(),
            'date' => $reportDate,
        ]);
    
        foreach ($tasks as $task) {
            $report->tasks()->create([
                'description' => $task['description'],
                'start_time' => $task['start'],
                'end_time' => $task['end'],
                'hours' => $task['hours'],
            ]);
        }
    
        return redirect()->back()->with('success', 'Report submitted successfully!');
    }

    public function show(Request $request)
    { 
        
        $requestDate = $request->report_date;
        if ($requestDate && str_contains($requestDate, '/')) {
            $requestDate = Carbon::createFromFormat('Y/m/d', $requestDate)->format('Y-m-d');
            }
            $dateReports = DailyReport::with('tasks', 'user')
                ->whereDate('date', $requestDate)
                ->get();
            $allUser = User::all();
            return view('reports', compact('dateReports', 'allUser', 'requestDate'));
    }  

    public function showForm(Request $request)
{
    $reportDate = $request->query('report_date', date('Y-m-d'));
    $userId = auth()->id();

    $report = DailyReport::where('user_id', $userId)
                ->whereDate('date', $reportDate)
                ->with('tasks')
                ->first();

    return view('daily_report', compact('report', 'reportDate'));
}

}