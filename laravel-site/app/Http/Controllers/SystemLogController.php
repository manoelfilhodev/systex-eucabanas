<?php

namespace App\Http\Controllers;

use App\Models\Legacy\SystemLog;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class SystemLogController extends Controller
{
    public function __invoke(): View
    {
        return view('logs.index', [
            'logs' => Schema::hasTable('_tb_log')
                ? SystemLog::query()->with('user')->orderByDesc('log_id')->paginate(30)
                : collect(),
        ]);
    }
}
