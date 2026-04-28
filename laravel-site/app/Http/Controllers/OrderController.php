<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Legacy\Order;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Schema;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Schema::hasTable('_tb_orders')
            ? Order::query()->orderByDesc('ord_id')->paginate(20)
            : collect();

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('orders.form', ['order' => new Order]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request, ActivityLogger $logger)
    {
        $order = Order::query()->create($request->validated());

        $logger->record('create', "USUARIO {$request->user()->name} CADASTROU A COMPRA {$order->ord_name}");

        return redirect()->route('orders.index')->with('status', 'Compra cadastrada com sucesso.');
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
        return view('orders.form', ['order' => Order::query()->findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrderRequest $request, string $id, ActivityLogger $logger)
    {
        $order = Order::query()->findOrFail($id);
        $order->update($request->validated());

        $logger->record('update', "USUARIO {$request->user()->name} ALTEROU A COMPRA {$order->ord_name}");

        return redirect()->route('orders.index')->with('status', 'Compra atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ActivityLogger $logger)
    {
        $order = Order::query()->findOrFail($id);
        $orderName = $order->ord_name;
        $order->delete();

        $logger->record('delete', 'USUARIO '.auth()->user()?->name." REMOVEU A COMPRA {$orderName}");

        return redirect()->route('orders.index')->with('status', 'Compra removida com sucesso.');
    }
}
