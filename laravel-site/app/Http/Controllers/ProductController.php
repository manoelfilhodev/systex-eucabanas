<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Legacy\Product;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Schema::hasTable('_tb_products')
            ? Product::query()
                ->when(! $request->user()?->isAdmin(), fn ($query) => $query->where('prod_status', 'ATIVO'))
                ->when($request->user()?->isAdmin() && $request->boolean('inactive'), fn ($query) => $query->where('prod_status', 'INATIVO'))
                ->when($request->user()?->isAdmin() && ! $request->boolean('inactive'), fn ($query) => $query->where('prod_status', 'ATIVO'))
                ->orderBy('prod_family')
                ->orderBy('prod_name')
                ->paginate(20)
                ->withQueryString()
            : collect();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.form', ['product' => new Product]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request, ActivityLogger $logger)
    {
        $data = $request->validated();

        if (! $request->user()?->isAdmin()) {
            $data['prod_status'] = 'ATIVO';
        }

        $product = Product::query()->create($data + [
            'prod_fk_id_user' => $request->user()->getKey(),
            'prod_date_cad' => now()->format('Y-m-d H:i:s'),
        ]);

        $logger->record('create', "USUARIO {$request->user()->name} CADASTROU O PRODUTO {$product->prod_name}");

        return redirect()->route('products.index')->with('status', 'Produto cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::query()->findOrFail($id);

        abort_unless(auth()->user()?->isAdmin() || $product->prod_status === 'ATIVO', 403);

        return view('products.form', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, string $id, ActivityLogger $logger)
    {
        $product = Product::query()->findOrFail($id);

        abort_unless($request->user()?->isAdmin() || $product->prod_status === 'ATIVO', 403);

        $data = $request->validated();

        if (! $request->user()?->isAdmin()) {
            unset($data['prod_status']);
        }

        $product->update($data);

        $logger->record('update', "USUARIO {$request->user()->name} ALTEROU O PRODUTO {$product->prod_name}");

        return redirect()->route('products.index')->with('status', 'Produto atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id, ActivityLogger $logger)
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $product = Product::query()->findOrFail($id);
        $product->update(['prod_status' => 'INATIVO']);

        $logger->record('delete', 'PRODUTO INATIVADO '.$product->prod_name);

        return redirect()->route('products.index')->with('status', 'Produto inativado com sucesso.');
    }
}
