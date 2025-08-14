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
            $this->idCliente    = $id;
            $cliente            = ClienteModel::findOrFail($id);

            $this->nome        = $cliente->nome;
            $this->cnpj        = $cliente->cnpj;
            $this->contato     = $cliente->contato;
            $this->email       = $cliente->email;
            $this->endereco    = $cliente->endereco;
            $this->observacao  = $cliente->observacao;
        }
    }

    public function salvarCliente()
    {
        $cleanCnpj    = preg_replace('/\D/', '', $this->cnpj) ?: null;
        $cleanContato = preg_replace('/\D/', '', $this->contato) ?: null;
        $cleanEmail   = trim($this->email) ?: null;

        $data = [
            'nome'       => $this->nome,
            'cnpj'       => $cleanCnpj,
            'contato'    => $cleanContato,
            'email'      => $cleanEmail,
            'endereco'   => $this->endereco,
            'observacao' => $this->observacao,
        ];

        try {
            if (! $this->idCliente && $cleanCnpj) {
                $trashed = ClienteModel::withTrashed()
                    ->where('cnpj', $cleanCnpj)
                    ->first();

                if ($trashed && $trashed->trashed()) {
                    $trashed->restore();
                    $trashed->update($data);

                    $this->js("alertaSucesso('Cliente reativado com sucesso!')");
                    $this->dispatch('closeModal');
                    $this->dispatch('reloadPowergrid');
                    return;
                }
            }

            if (! $this->idCliente && $cleanEmail) {
                $trashed = ClienteModel::withTrashed()
                    ->where('email', $cleanEmail)
                    ->first();

                if ($trashed && $trashed->trashed()) {
                    $trashed->restore();
                    $trashed->update($data);

                    $this->js("alertaSucesso('Cliente reativado com sucesso!')");
                    $this->dispatch('closeModal');
                    $this->dispatch('reloadPowergrid');
                    return;
                }
            }

            if ($this->idCliente) {
                ClienteModel::find($this->idCliente)->update($data);
                $this->js("alertaSucesso('Cliente editado com sucesso!')");
            } else {
                ClienteModel::create($data);
                $this->js("alertaSucesso('Cliente cadastrado com sucesso!')");
            }

            $this->dispatch('closeModal');
            $this->dispatch('reloadPowergrid');
        } catch (\Throwable $e) {
            $this->js("alertaFalha('Erro ao salvar cliente. Tente novamente.')");
        }
    }

    public function render()
    {
        return view('livewire.modal.cliente');
    }
}
