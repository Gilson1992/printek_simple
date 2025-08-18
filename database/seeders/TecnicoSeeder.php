<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tecnico;
use App\Enums\Disponibilidade;

class TecnicoSeeder extends Seeder
{
    public function run(): void
    {
        $tecnicos = [
            [
                'matricula'       => 'TEC001',
                'nome'            => 'Carlos Silva',
                'contato'         => '11987654321',
                'disponibilidade' => Disponibilidade::Disponivel->value,
            ],
            [
                'matricula'       => 'TEC002',
                'nome'            => 'Ana Souza',
                'contato'         => '21998887766',
                'disponibilidade' => Disponibilidade::EmAtendimento->value,
            ],
            [
                'matricula'       => 'TEC003',
                'nome'            => 'Pedro Martins',
                'contato'         => '31997776655',
                'disponibilidade' => Disponibilidade::Disponivel->value,
            ],
        ];

        foreach ($tecnicos as $tecnico) {
            Tecnico::create($tecnico);
        }
    }
}
