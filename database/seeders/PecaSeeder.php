<?php

namespace Database\Seeders;

use App\Models\Peca;
use Illuminate\Database\Seeder;

class PecaSeeder extends Seeder
{
    public function run(): void
    {
        $pecas = [
            [
                'descricao'  => 'Cartucho de Tinta Preto HP 664',
                'codigo'     => 'HP664BK',
                'quantidade' => 10,
                'unidade'    => 'UN',
                'preco'      => 79.90,
            ],
            [
                'descricao'  => 'Cartucho de Tinta Colorido HP 664',
                'codigo'     => 'HP664CL',
                'quantidade' => 8,
                'unidade'    => 'UN',
                'preco'      => 85.00,
            ],
            [
                'descricao'  => 'Toner Brother TN-2370 Preto',
                'codigo'     => 'TN2370',
                'quantidade' => 15,
                'unidade'    => 'UN',
                'preco'      => 129.99,
            ],
            [
                'descricao'  => 'Cilindro Brother DR-2370',
                'codigo'     => 'DR2370',
                'quantidade' => 5,
                'unidade'    => 'UN',
                'preco'      => 199.90,
            ],
            [
                'descricao'  => 'Fusor HP LaserJet M402 M426',
                'codigo'     => 'FUSORM402',
                'quantidade' => 3,
                'unidade'    => 'UN',
                'preco'      => 320.00,
            ],
            [
                'descricao'  => 'Rolo de Transferência Ricoh Aficio MP2014',
                'codigo'     => 'ROLORIC2014',
                'quantidade' => 7,
                'unidade'    => 'UN',
                'preco'      => 180.50,
            ],
            [
                'descricao'  => 'Cilindro Fotocondutor Konica Minolta DR512',
                'codigo'     => 'DR512',
                'quantidade' => 4,
                'unidade'    => 'UN',
                'preco'      => 470.75,
            ],
            [
                'descricao'  => 'Unidade de Imagem Samsung MLT-R116',
                'codigo'     => 'MLTR116',
                'quantidade' => 6,
                'unidade'    => 'UN',
                'preco'      => 210.00,
            ],
        ];

        foreach ($pecas as $peca) {
            Peca::create($peca);
        }
    }
}
