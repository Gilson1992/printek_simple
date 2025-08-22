<?php

namespace Database\Seeders;

use App\Models\Servico;
use Illuminate\Database\Seeder;

class ServicoSeeder extends Seeder
{
    public function run(): void
    {
        $servicos = [
            [
                'descricao' => 'Manutenção preventiva em impressora laser',
                'codigo'    => 'SERV001',
                'contador'  => 1,
                'preco'     => 120.00,
            ],
            [
                'descricao' => 'Manutenção corretiva em multifuncional',
                'codigo'    => 'SERV002',
                'contador'  => 1,
                'preco'     => 180.50,
            ],
            [
                'descricao' => 'Troca de cilindro e limpeza interna',
                'codigo'    => 'SERV003',
                'contador'  => 1,
                'preco'     => 95.00,
            ],
            [
                'descricao' => 'Configuração de scanner em rede',
                'codigo'    => 'SERV004',
                'contador'  => 1,
                'preco'     => 75.00,
            ],
            [
                'descricao' => 'Atualização de firmware da impressora',
                'codigo'    => 'SERV005',
                'contador'  => 1,
                'preco'     => 60.00,
            ],
            [
                'descricao' => 'Instalação de driver e configuração USB',
                'codigo'    => 'SERV006',
                'contador'  => 1,
                'preco'     => 40.00,
            ],
            [
                'descricao' => 'Diagnóstico de falha de impressão',
                'codigo'    => 'SERV007',
                'contador'  => 1,
                'preco'     => 50.00,
            ],
            [
                'descricao' => 'Troca de fusor em impressora laser',
                'codigo'    => 'SERV008',
                'contador'  => 1,
                'preco'     => 200.00,
            ],
            [
                'descricao' => 'Limpeza de roletes de tração',
                'codigo'    => 'SERV009',
                'contador'  => 1,
                'preco'     => 65.00,
            ],
            [
                'descricao' => 'Remoção de atolamento frequente',
                'codigo'    => 'SERV010',
                'contador'  => 1,
                'preco'     => 85.00,
            ],
        ];

        foreach ($servicos as $servico) {
            Servico::create($servico);
        }
    }
}
