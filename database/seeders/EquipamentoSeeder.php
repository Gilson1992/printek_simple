<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipamento;
use App\Models\Cliente;
use App\Enums\Tipo;
use App\Enums\TipoPosse;

class EquipamentoSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = Cliente::all();

        foreach ($clientes as $cliente) {
            Equipamento::create([
                'cliente_id'  => $cliente->id,
                'tipo'        => fake()->randomElement([Tipo::Impressora->value, Tipo::Multifuncional->value]),
                'tipo_posse'  => fake()->randomElement([TipoPosse::Proprio->value, TipoPosse::Locado->value]),
                'marca'       => fake()->randomElement(['HP', 'Epson', 'Canon', 'Brother']),
                'modelo'      => fake()->bothify('Modelo-###??'),
                'serial'      => fake()->unique()->bothify('SN######'),
                'contador'    => fake()->numberBetween(100, 5000),
                'observacao'  => fake()->boolean() ? fake()->sentence() : null,
            ]);
        }
    }
}
