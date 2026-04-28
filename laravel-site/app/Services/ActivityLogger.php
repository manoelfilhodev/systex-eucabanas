<?php

namespace App\Services;

use App\Models\Legacy\SystemLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class ActivityLogger
{
    public function record(string $action, string $message): void
    {
        if (! Schema::hasTable('_tb_log')) {
            return;
        }

        SystemLog::query()->create([
            'log_id_user' => Auth::id(),
            'log_data' => now()->format('Y-m-d H:i:s'),
            'log_id_movimento' => strtoupper($action).' - '.$message,
        ]);
    }
}
