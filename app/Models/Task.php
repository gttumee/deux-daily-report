<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'report_id',
        'description',
        'start_time',
        'end_time',
        'hours',
    ];
    public function report()
{
    return $this->belongsTo(DailyReport::class);
}
}
