<?php

namespace Tests\Feature;

use App\Models\Legacy\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_product_logically(): void
    {
        $admin = User::query()->where('login', 'admin@systex.local')->firstOrFail();
        $product = $this->createProduct();

        $response = $this->actingAs($admin)->delete(route('products.destroy', $product));

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('status', 'Produto excluído com sucesso.');
        $this->assertDatabaseHas('_tb_products', [
            'prod_id' => $product->getKey(),
            'prod_status' => 'INATIVO',
        ]);
        $this->assertDatabaseHas('_tb_log', [
            'log_id_user' => $admin->getKey(),
            'log_id_movimento' => "DELETE - ADMIN {$admin->name} EXCLUIU LOGICAMENTE O PRODUTO {$product->prod_name}",
        ]);
    }

    public function test_non_admin_cannot_delete_product(): void
    {
        $user = User::query()->create([
            'nome' => 'Operacao',
            'login' => 'operacao@example.com',
            'senha' => Hash::make('password'),
            'status' => 'ATIVO',
            'cod_nivel' => '1',
            'desc_nivel' => 'Usuario',
        ]);
        $product = $this->createProduct();

        $response = $this->actingAs($user)->delete(route('products.destroy', $product));

        $response->assertForbidden();
        $this->assertDatabaseHas('_tb_products', [
            'prod_id' => $product->getKey(),
            'prod_status' => 'ATIVO',
        ]);
    }

    public function test_product_listing_has_delete_confirmation_for_admins(): void
    {
        $admin = User::query()->where('login', 'admin@systex.local')->firstOrFail();
        $product = $this->createProduct();

        $response = $this->actingAs($admin)->get(route('products.index'));

        $response->assertOk();
        $response->assertSee('Excluir');
        $response->assertSee('Tem certeza que deseja excluir este produto?', false);
        $response->assertSee(route('products.destroy', $product), false);
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
