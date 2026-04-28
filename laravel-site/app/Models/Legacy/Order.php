<?php

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = '_tb_orders';

    protected $primaryKey = 'ord_id';

    public $timestamps = false;

    protected $guarded = ['ord_id'];
}
