<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipamento;
use App\Enums\{Tipo, TipoPosse};

class EquipamentoSeeder extends Seeder
{
    public function run(): void
    {
        $quantidade = 20;

        for ($i = 0; $i < $quantidade; $i++) {
            Equipamento::create([
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
