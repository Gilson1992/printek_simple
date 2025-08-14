<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            [
                'nome' => 'Tech Solutions LTDA',
                'cnpj' => '12345678000195',
                'contato' => '11987654321',
                'email' => 'contato@techsolutions.com',
                'endereco' => 'Av. Paulista, 1000, São Paulo, SP, 01310-100',
                'observacao' => 'Cliente VIP',
                'ativo' => true,
            ],
            [
                'nome' => 'Alfa Comércio de Alimentos',
                'cnpj' => '98765432000188',
                'contato' => '11912345678',
                'email' => 'vendas@alfacomercio.com.br',
                'endereco' => 'Rua das Flores, 50, Rio de Janeiro, RJ, 20000-000',
                'ativo' => true,
            ],
            [
                'nome' => 'Beta Indústria Mecânica',
                'cnpj' => '45678912000177',
                'contato' => '21999887766',
                'email' => 'suporte@betaindustria.com',
                'endereco' => 'Av. Brasil, 1500, Belo Horizonte, MG, 30140-000',
                'observacao' => 'Cliente com contrato anual',
                'ativo' => false,
            ],
            [
                'nome' => 'Gamma Serviços Digitais',
                'cnpj' => '11223344000155',
                'contato' => '31987654321',
                'email' => 'atendimento@gammaservicos.com',
                'endereco' => 'Rua Central, 88, Curitiba, PR, 80010-100',
                'ativo' => true,
            ],
            [
                'nome' => 'Delta Transportes',
                'cnpj' => '55443322000199',
                'contato' => '41999887755',
                'email' => 'logistica@deltatransportes.com',
                'endereco' => 'Av. das Nações, 200, Porto Alegre, RS, 90010-200',
                'ativo' => true,
            ],
            [
                'nome' => 'Epsilon Engenharia',
                'cnpj' => '66778899000111',
                'contato' => '51988776655',
                'email' => 'contato@epsilonengenharia.com.br',
                'endereco' => 'Rua dos Engenheiros, 10, Florianópolis, SC, 88010-000',
                'ativo' => false,
            ],
            [
                'nome' => 'Zeta Construtora',
                'cnpj' => '77889966000144',
                'contato' => '62998765432',
                'email' => 'contato@zetaconstrutora.com',
                'endereco' => 'Av. Goiás, 123, Goiânia, GO, 74000-000',
                'ativo' => true,
            ],
            [
                'nome' => 'Omega Comércio e Importação',
                'cnpj' => '88990077000122',
                'contato' => '71912349876',
                'email' => 'vendas@omegacomercio.com',
                'endereco' => 'Rua do Comércio, 222, Salvador, BA, 40000-000',
                'ativo' => true,
            ],
            [
                'nome' => 'Sigma Tech Store',
                'cnpj' => '99001188000133',
                'contato' => '81998761234',
                'email' => 'suporte@sigmatech.com.br',
                'endereco' => 'Av. Recife, 999, Recife, PE, 50000-000',
                'ativo' => true,
            ],
            [
                'nome' => 'Theta Cosméticos',
                'cnpj' => '22334455000166',
                'contato' => '85991234567',
                'email' => 'contato@thetacosmeticos.com',
                'endereco' => 'Rua das Belezas, 77, Fortaleza, CE, 60000-000',
                'ativo' => false,
            ],
            [
                'nome' => 'Kappa Educação',
                'cnpj' => '33445566000177',
                'contato' => '98992345678',
                'email' => 'contato@kappaeducacao.com',
                'endereco' => 'Av. do Conhecimento, 10, São Luís, MA, 65000-000',
                'ativo' => true,
            ],
            [
                'nome' => 'Lambda Software',
                'cnpj' => '44556677000188',
                'contato' => '11988887777',
                'email' => 'suporte@lambdasoft.com',
                'endereco' => 'Rua dos Desenvolvedores, 99, São Paulo, SP, 01000-000',
                'ativo' => true,
            ],
            [
                'nome' => 'Rho Equipamentos Médicos',
                'cnpj' => '55667788000199',
                'contato' => '21977776666',
                'email' => 'vendas@rhoequipamentos.com',
                'endereco' => 'Av. Saúde, 150, Rio de Janeiro, RJ, 22000-000',
                'ativo' => false,
            ],
            [
                'nome' => 'Pi Consultoria',
                'cnpj' => '66778899000100',
                'contato' => '31966665555',
                'email' => 'contato@piconsultoria.com',
                'endereco' => 'Rua das Empresas, 25, Belo Horizonte, MG, 30100-000',
                'ativo' => true,
            ],
            [
                'nome' => 'Mu Papelaria e Escritório',
                'cnpj' => '77889900112233',
                'contato' => '41955554444',
                'email' => 'vendas@mupapelaria.com',
                'endereco' => 'Av. do Trabalho, 321, Curitiba, PR, 80000-000',
                'ativo' => true,
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
