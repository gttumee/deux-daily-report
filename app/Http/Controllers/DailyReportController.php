<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
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
    
        // Report作成
        $report = DailyReport::create([
            'user_id' => auth()->id(),
            'date' => $reportDate,
        ]);

        // Taskを紐づけて保存
        foreach ($tasks as $task) {
            $report->tasks()->create([
                // 'report_id'=>$report['id'],
                'description' => $task['description'],
                'start_time' => $task['start'],
                'end_time' => $task['end'],
                'hours' => $task['hours'],
            ]);
        }
    
        return redirect()->back()->with('success', 'Report submitted successfully!');
    }
    
}
