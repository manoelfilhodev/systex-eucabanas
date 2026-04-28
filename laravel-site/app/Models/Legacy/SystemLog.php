<?php

namespace App\Models\Legacy;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemLog extends Model
{
    protected $table = '_tb_log';

    protected $primaryKey = 'log_id';

    public $timestamps = false;

    protected $guarded = ['log_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'log_id_user', 'id_user');
    }
}
