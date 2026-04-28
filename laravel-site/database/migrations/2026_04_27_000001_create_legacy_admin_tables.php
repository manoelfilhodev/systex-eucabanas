<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('_tb_users')) {
            Schema::create('_tb_users', function (Blueprint $table): void {
                $table->id('id_user');
                $table->string('nome');
                $table->string('login')->unique();
                $table->string('senha');
                $table->string('status', 20)->default('ATIVO');
                $table->string('unidade')->nullable();
                $table->string('cod_nivel', 50)->nullable();
                $table->string('desc_nivel', 100)->nullable();
                $table->dateTime('data_cad_user')->nullable();
            });

            DB::table('_tb_users')->insert([
                'nome' => 'Administrador Systex',
                'login' => 'admin@systex.local',
                'senha' => Hash::make('password'),
                'status' => 'ATIVO',
                'unidade' => 'Systex',
                'cod_nivel' => '0',
                'desc_nivel' => 'Administrador',
                'data_cad_user' => now()->format('Y-m-d H:i:s'),
            ]);
        }

        if (! Schema::hasTable('_tb_products')) {
            Schema::create('_tb_products', function (Blueprint $table): void {
                $table->id('prod_id');
                $table->string('prod_name');
                $table->text('prod_desc')->nullable();
                $table->decimal('prod_price', 12, 2)->nullable();
                $table->integer('prod_qtde')->default(0);
                $table->string('prod_family')->nullable();
                $table->date('prod_valid')->nullable();
                $table->string('prod_foto', 1000)->nullable();
                $table->string('prod_status', 20)->default('ATIVO');
                $table->unsignedBigInteger('prod_fk_id_user')->nullable();
                $table->dateTime('prod_date_cad')->nullable();
            });
        }

        if (! Schema::hasTable('_tb_orders')) {
            Schema::create('_tb_orders', function (Blueprint $table): void {
                $table->id('ord_id');
                $table->string('ord_name')->nullable();
                $table->text('ord_desc')->nullable();
                $table->decimal('ord_value', 12, 2)->nullable();
                $table->string('ord_status', 50)->nullable();
                $table->date('ord_date')->nullable();
            });
        }

        if (! Schema::hasTable('_tb_log')) {
            Schema::create('_tb_log', function (Blueprint $table): void {
                $table->id('log_id');
                $table->unsignedBigInteger('log_id_user')->nullable();
                $table->dateTime('log_data')->nullable();
                $table->text('log_id_movimento');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('_tb_log');
        Schema::dropIfExists('_tb_orders');
        Schema::dropIfExists('_tb_products');
        Schema::dropIfExists('_tb_users');
    }
};
