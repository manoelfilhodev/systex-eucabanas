<?php

namespace App\Http\Controllers;

use App\Models\Legacy\Product;
use App\Services\ActivityLogger;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

class PurchaseListPdfController extends Controller
{
    public function __invoke(ActivityLogger $logger): Response
    {
        $products = Schema::hasTable('_tb_products')
            ? Product::query()
                ->where('prod_status', 'ATIVO')
                ->orderBy('prod_family')
                ->orderBy('prod_qtde')
                ->get()
                ->filter(fn (Product $product): bool => $product->purchaseStatus() !== Product::STATUS_AVAILABLE)
            : collect();

        $html = view('purchases.pdf', [
            'groups' => [
                Product::STATUS_CRITICAL => [
                    'label' => 'ITENS CRITICOS (VERMELHO)',
                    'products' => $products
                        ->filter(fn (Product $product): bool => $product->purchaseStatus() === Product::STATUS_CRITICAL)
                        ->groupBy(fn (Product $product): string => $product->prod_family ?: 'Sem família'),
                ],
                Product::STATUS_ATTENTION => [
                    'label' => 'ITENS EM ATENCAO (AMARELO)',
                    'products' => $products
                        ->filter(fn (Product $product): bool => $product->purchaseStatus() === Product::STATUS_ATTENTION)
                        ->groupBy(fn (Product $product): string => $product->prod_family ?: 'Sem família'),
                ],
            ],
            'totals' => [
                Product::STATUS_CRITICAL => $products->filter(fn (Product $product): bool => $product->purchaseStatus() === Product::STATUS_CRITICAL)->count(),
                Product::STATUS_ATTENTION => $products->filter(fn (Product $product): bool => $product->purchaseStatus() === Product::STATUS_ATTENTION)->count(),
            ],
            'generatedAt' => now()->format('d/m/Y H:i'),
        ])->render();

        $logger->record('export', 'ADMIN GEROU PDF DE COMPRA');

        $options = new Options;
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="lista-de-compras.pdf"',
        ]);
    }
}
