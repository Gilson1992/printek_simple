<?php

namespace App\Enums;

enum StatusOs:string
{
    case Aberta = 'Aberta';
    case EmAtendimento = 'Em Atendimento';
    case AguardandoPecas = 'Aguardando Peças';
    case Finalizada = 'Finalizada';
}
