<?php

namespace App\Livewire\Modal;

use LivewireUI\Modal\ModalComponent;

class Cliente extends ModalComponent
{
    public $nome;
    public $cnpj;
    public $contato;
    public $email;
    public $endereco;
    public $observacao;

    public function mount()
    {

    }

    public function salvarCliente()
    {

        $this->dipatch('closeModal');
        $this->dipatch('reloadPowergrid');
    }

    public function render()
    {
        return view('livewire.modal.cliente');
    }
}
