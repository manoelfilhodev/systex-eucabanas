<?php

namespace App\Http\Controllers;

use App\Models\Legacy\Product;
use App\Models\Legacy\SystemLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = Auth::user();
        $products = Schema::hasTable('_tb_products')
            ? Product::query()->where('prod_status', 'ATIVO')->get()
            : collect();

        $statusCounts = [
            Product::STATUS_AVAILABLE => $products->filter(fn (Product $product): bool => $product->purchaseStatus() === Product::STATUS_AVAILABLE)->count(),
            Product::STATUS_ATTENTION => $products->filter(fn (Product $product): bool => $product->purchaseStatus() === Product::STATUS_ATTENTION)->count(),
            Product::STATUS_CRITICAL => $products->filter(fn (Product $product): bool => $product->purchaseStatus() === Product::STATUS_CRITICAL)->count(),
        ];

        return view('dashboard.index', [
            'productsTotal' => $products->count(),
            'statusCounts' => $statusCounts,
            'purchaseProducts' => $products
                ->filter(fn (Product $product): bool => $product->purchaseStatus() === Product::STATUS_CRITICAL)
                ->sortBy([['prod_family', 'asc'], ['prod_qtde', 'asc'], ['prod_name', 'asc']]),
            'logs' => $user?->isAdmin() && Schema::hasTable('_tb_log')
                ? SystemLog::query()->with('user')->orderByDesc('log_id')->limit(10)->get()
                : collect(),
        ]);
    }
}
