<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    protected $fillable = [
        'user_id',
        'date',
    ];

    public function tasks()
{
    return $this->hasMany(Task::class,'report_id');
}
}
