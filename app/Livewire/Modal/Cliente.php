<?php

namespace App\Livewire\Modal;

use App\Models\Cliente as ClienteModel;
use LivewireUI\Modal\ModalComponent;

class Cliente extends ModalComponent
{
    public $idCliente;
    public $nome;
    public $cnpj;
    public $contato;
    public $email;
    public $endereco;
    public $observacao;

    public function mount($id = null)
    {
        if ($id) {
            $this->idCliente = $id;
            $cliente = ClienteModel::findOrFail($id);

            $this->nome = $cliente->nome;
            $this->cnpj = $cliente->cnpj;
            $this->contato = $cliente->contato;
            $this->email = $cliente->email;
            $this->endereco  = $cliente->endereco;
            $this->observacao = $cliente->observacao;
        }
    }

    public function salvarCliente()
    {
        $cleanCnpj    = preg_replace('/\D/', '', $this->cnpj);
        $cleanContato = preg_replace('/\D/', '', $this->contato);

        $data = [
            'nome' => $this->nome,
            'cnpj' => $cleanCnpj,
            'contato' => $cleanContato,
            'email' => $this->email,
            'endereco' => $this->endereco,
            'observacao' => $this->observacao,
        ];

        if ($this->idCliente) {
            ClienteModel::find($this->idCliente)->update($data);
        } else {
            ClienteModel::create($data);
        }

        $this->dispatch('closeModal');
        $this->dispatch('reloadPowergrid');
    }

    public function render()
    {
        return view('livewire.modal.cliente');
    }
}
