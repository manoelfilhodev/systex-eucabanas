<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            throw new RuntimeException('O seed demonstrativo só pode rodar em ambiente local ou de testes.');
        }

        DB::table('_tb_log')->delete();
        DB::table('_tb_orders')->delete();
        DB::table('_tb_products')->delete();
        DB::table('_tb_users')->delete();

        $now = now();

        DB::table('_tb_users')->insert([
            [
                'id_user' => 1,
                'nome' => 'Administrador Hotel',
                'login' => 'admin@hotel.local',
                'senha' => Hash::make('password'),
                'status' => 'ATIVO',
                'unidade' => 'Hotel',
                'cod_nivel' => '0',
                'desc_nivel' => 'Administrador',
                'data_cad_user' => $now->copy()->subDays(30)->format('Y-m-d H:i:s'),
            ],
            [
                'id_user' => 2,
                'nome' => 'Operacao Cozinha',
                'login' => 'cozinha@hotel.local',
                'senha' => Hash::make('password'),
                'status' => 'ATIVO',
                'unidade' => 'Cozinha',
                'cod_nivel' => '1',
                'desc_nivel' => 'Usuario',
                'data_cad_user' => $now->copy()->subDays(20)->format('Y-m-d H:i:s'),
            ],
            [
                'id_user' => 3,
                'nome' => 'Governanca Hotel',
                'login' => 'governanca@hotel.local',
                'senha' => Hash::make('password'),
                'status' => 'ATIVO',
                'unidade' => 'Governanca',
                'cod_nivel' => '1',
                'desc_nivel' => 'Usuario',
                'data_cad_user' => $now->copy()->subDays(18)->format('Y-m-d H:i:s'),
            ],
        ]);

        $products = [
            ['Arroz agulhinha 5kg', 'Alimentos', 31.90, 12, 90],
            ['Feijao carioca 1kg', 'Alimentos', 8.90, 5, 75],
            ['Cafe torrado 500g', 'Alimentos', 18.50, 3, 120],
            ['Acucar refinado 1kg', 'Alimentos', 4.80, 18, 150],
            ['Oleo de soja 900ml', 'Alimentos', 7.40, 2, 180],
            ['Leite integral 1L', 'Alimentos', 5.70, 4, 12],
            ['Manteiga 500g', 'Alimentos', 22.90, 1, 18],
            ['Queijo mussarela kg', 'Alimentos', 39.90, 7, 10],
            ['Peito de frango kg', 'Alimentos', 19.90, 3, 7],
            ['Carne moida kg', 'Alimentos', 34.90, 6, 6],
            ['Ovos bandeja 30un', 'Alimentos', 24.50, 5, 14],
            ['Tomate kg', 'Alimentos', 8.30, 2, 5],
            ['Banana prata kg', 'Alimentos', 6.20, 9, 4],
            ['Papel higienico fardo', 'Produtos de Limpeza', 54.90, 4, null],
            ['Detergente neutro 5L', 'Produtos de Limpeza', 18.90, 10, null],
            ['Desinfetante 5L', 'Produtos de Limpeza', 16.50, 3, null],
            ['Agua sanitaria 5L', 'Produtos de Limpeza', 12.90, 1, null],
            ['Sabonete hotelaria cx', 'Produtos de Revenda', 79.90, 8, null],
            ['Shampoo sachê cx', 'Produtos de Revenda', 69.90, 5, null],
            ['Touca descartavel cx', 'Produtos de Revenda', 32.00, 2, null],
        ];

        foreach ($products as $index => [$name, $family, $price, $quantity, $validDays]) {
            DB::table('_tb_products')->insert([
                'prod_name' => $name,
                'prod_desc' => "Item de controle diario do hotel: {$name}.",
                'prod_price' => $price,
                'prod_qtde' => $quantity,
                'prod_family' => $family,
                'prod_valid' => $validDays ? $now->copy()->addDays($validDays)->format('Y-m-d') : null,
                'prod_foto' => null,
                'prod_status' => 'ATIVO',
                'prod_fk_id_user' => ($index % 2) + 2,
                'prod_date_cad' => $now->copy()->subDays(15 - min($index, 14))->format('Y-m-d H:i:s'),
            ]);
        }

        DB::table('_tb_orders')->insert([
            [
                'ord_name' => 'Reposicao semanal alimentos',
                'ord_desc' => 'Compra prevista para itens amarelos e vermelhos da cozinha.',
                'ord_value' => 680.00,
                'ord_status' => 'ABERTA',
                'ord_date' => $now->copy()->addDay()->format('Y-m-d'),
            ],
            [
                'ord_name' => 'Produtos de limpeza urgentes',
                'ord_desc' => 'Reposicao de agua sanitaria, desinfetante e papel.',
                'ord_value' => 320.00,
                'ord_status' => 'EM COTACAO',
                'ord_date' => $now->format('Y-m-d'),
            ],
        ]);

        DB::table('_tb_log')->insert([
            ['log_id_user' => 1, 'log_data' => $now->copy()->subMinutes(8)->format('Y-m-d H:i:s'), 'log_id_movimento' => 'LOGIN - USUARIO Administrador Hotel ENTROU'],
            ['log_id_user' => 2, 'log_data' => $now->copy()->subMinutes(22)->format('Y-m-d H:i:s'), 'log_id_movimento' => 'UPDATE - USUARIO Operacao Cozinha ALTEROU O PRODUTO Leite integral 1L'],
            ['log_id_user' => 3, 'log_data' => $now->copy()->subMinutes(37)->format('Y-m-d H:i:s'), 'log_id_movimento' => 'UPDATE - USUARIO Governanca Hotel ALTEROU O PRODUTO Desinfetante 5L'],
            ['log_id_user' => 1, 'log_data' => $now->copy()->subHour()->format('Y-m-d H:i:s'), 'log_id_movimento' => 'CREATE - ADMIN Administrador Hotel CADASTROU A COMPRA Produtos de limpeza urgentes'],
            ['log_id_user' => 2, 'log_data' => $now->copy()->subHours(2)->format('Y-m-d H:i:s'), 'log_id_movimento' => 'LOGIN - USUARIO Operacao Cozinha ENTROU'],
            ['log_id_user' => 3, 'log_data' => $now->copy()->subHours(3)->format('Y-m-d H:i:s'), 'log_id_movimento' => 'CREATE - USUARIO Governanca Hotel CADASTROU O PRODUTO Touca descartavel cx'],
        ]);
    }
}
