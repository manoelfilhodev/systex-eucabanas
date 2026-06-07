<?php

namespace Tests\Feature;

use App\Models\Legacy\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_search_products_by_name(): void
    {
        $user = User::query()->where('login', 'admin@systex.local')->firstOrFail();
        $coffee = $this->createProduct(['prod_name' => 'Cafe especial', 'prod_family' => 'Alimentos']);
        $soap = $this->createProduct(['prod_name' => 'Sabonete hotelaria', 'prod_family' => 'Produtos de Revenda']);

        $response = $this->actingAs($user)->get(route('products.index', ['search' => 'cafe']));

        $response->assertOk();
        $response->assertSee($coffee->prod_name);
        $response->assertDontSee($soap->prod_name);
        $response->assertSee('Pesquisar produtos');
    }

    public function test_search_keeps_inactive_filter_for_admins(): void
    {
        $admin = User::query()->where('login', 'admin@systex.local')->firstOrFail();
        $inactiveProduct = $this->createProduct([
            'prod_name' => 'Desinfetante inativo',
            'prod_family' => 'Produtos de Limpeza',
            'prod_status' => 'INATIVO',
        ]);
        $this->createProduct([
            'prod_name' => 'Desinfetante ativo',
            'prod_family' => 'Produtos de Limpeza',
        ]);

        $response = $this->actingAs($admin)->get(route('products.index', [
            'inactive' => 1,
            'search' => 'desinfetante',
        ]));

        $response->assertOk();
        $response->assertSee($inactiveProduct->prod_name);
        $response->assertDontSee('Desinfetante ativo');
    }

    private function createProduct(array $attributes = []): Product
    {
        return Product::query()->create($attributes + [
            'prod_name' => 'Produto Teste',
            'prod_desc' => 'Produto usado nos testes.',
            'prod_price' => 10.50,
            'prod_qtde' => 8,
            'prod_family' => 'Alimentos',
            'prod_valid' => now()->addMonth()->format('Y-m-d'),
            'prod_status' => 'ATIVO',
            'prod_fk_id_user' => 1,
            'prod_date_cad' => now()->format('Y-m-d H:i:s'),
        ]);
    }
}
