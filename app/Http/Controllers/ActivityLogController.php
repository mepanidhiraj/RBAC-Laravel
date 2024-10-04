<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = Activity::with('causer')->orderBy('created_at', 'desc')->paginate(10);

        return view('activity_log.index', compact('activities'));
    }
}
