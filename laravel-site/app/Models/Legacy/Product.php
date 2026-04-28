<?php

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public const STATUS_AVAILABLE = 'available';

    public const STATUS_ATTENTION = 'attention';

    public const STATUS_CRITICAL = 'critical';

    protected $table = '_tb_products';

    protected $primaryKey = 'prod_id';

    public $timestamps = false;

    protected $guarded = ['prod_id'];

    public function purchaseStatus(): string
    {
        $quantity = (int) ($this->prod_qtde ?? 0);

        if ($quantity < 4) {
            return self::STATUS_CRITICAL;
        }

        if ($quantity < 6) {
            return self::STATUS_ATTENTION;
        }

        return self::STATUS_AVAILABLE;
    }

    public function purchaseStatusLabel(): string
    {
        return match ($this->purchaseStatus()) {
            self::STATUS_CRITICAL => 'Saldo Crítico',
            self::STATUS_ATTENTION => 'Saldo em Atenção',
            default => 'Saldo Disponível',
        };
    }

    public function purchaseStatusBadgeClass(): string
    {
        return match ($this->purchaseStatus()) {
            self::STATUS_CRITICAL => 'bg-danger',
            self::STATUS_ATTENTION => 'bg-warning text-dark',
            default => 'bg-success',
        };
    }

    public function daysToExpire(): ?int
    {
        if (blank($this->prod_valid)) {
            return null;
        }

        return now()->startOfDay()->diffInDays($this->prod_valid, false);
    }
}
