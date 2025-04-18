<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use App\Models\Task;
use App\Models\User;
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
        $allUser = User::all();
        $allData = Task::all();
        return view('reports',compact('allUser'));
    }  
}
